<?php

namespace App\Service;

use InvalidArgumentException;
use App\Worker;
use App\Job;

class WorkerService
{
    protected $worker_id;

    public function __construct($worker_id = null)
    {
        $this->worker_id = $worker_id;
    }

    public function save(array $data)
    {
        $this->validate($data);

        if ($this->worker_id) {
            $worker = Worker::find($this->worker_id);
        }else {
            $worker = new Worker;
        }

        $worker->name = $data['name'];
        $worker->type = $data['type'];
        $worker->telephone = $data['telephone'];

        if ( ! $worker->save()) {
            throw new InvalidArgumentException('保存客户失败');
        }
    }

    public function destroy()
    {
        try {
            $worker = Worker::find($this->worker_id);

            Job::where('worker_id', '=', $this->worker_id)->delete();

            if ( ! $worker->delete()) {
                throw new InvalidArgumentException('失败：不能删除该员工');
            }
        }catch (Exception $e) {
            throw new InvalidArgumentException('失败：不能删除该员工');
        }
    }

    protected function validate(array $data)
    {
        if (empty($data['name'])) {
            throw new InvalidArgumentException('客户名字不能为空.');
        }
    }
}
