<?php

namespace App\Service;

use InvalidArgumentException;
use App\Job;
use App\Product;
use DB;

class JobService
{
    protected $job_id;

    public function __construct($job_id = null)
    {
        $this->job_id = $job_id;
    }

    public function findByMonth($worker_id, $month)
    {
        return DB::table('jobs')
            ->join('products', 'jobs.product_id', '=', 'products.id')
            ->where('jobs.worker_id', '=', $worker_id)
            ->whereYear('jobs.updated_at', date("Y"))
            ->whereMonth('jobs.updated_at', $month)
            ->select(
                'jobs.id',
                'jobs.product_id',
                'jobs.worker_id',
                'jobs.quantity',
                'jobs.amount',
                DB::raw('DATE_FORMAT(jobs.updated_at, "%m/%d") as job_date'),
                'products.name',
                'products.fee')
            ->get();
    }

    public function save(array $data)
    {
        $this->validate($data);

        if ($this->job_id) {
            $job = Job::find($this->job_id);
        }else {
            $job = new Job;
        }

        $job->product_id = $data['product_id'];
        $job->worker_id = $data['worker_id'];
        $job->quantity = $data['quantity'];

        $product = Product::find($data['product_id']);
        if ( ! $product) {
            throw new InvalidArgumentException('产品不存在');
        }
        $job->amount = $product->fee * $data['quantity'];

        if (isset($data['month']) && isset($data['day'])) {
            $date_string = date('Y') . '-' . $data['month'] . '-' . $data['day'];
            $job->updated_at = date('Y-m-d', strtotime($date_string));
        }

        if ( ! $job->save()) {
            throw new InvalidArgumentException('保存人工费失败');
        }
    }

    public function destroy()
    {
        try {
            $job = Job::find($this->job_id);

            if ( ! $job->delete()) {
                throw new InvalidArgumentException('失败：不能删除该人工信息');
            }
        }catch (Exception $e) {
            throw new InvalidArgumentException('失败：不能删除该人工信息');
        }
    }

    protected function validate(array $data)
    {
        if (empty($data['product_id'])) {
            throw new InvalidArgumentException('请选择相应产品.');
        }

        if (empty($data['worker_id'])) {
            throw new InvalidArgumentException('员工不能为空');
        }

        if (empty($data['quantity'])) {
            throw new InvalidArgumentException('数量不能为空');
        }
    }
}
