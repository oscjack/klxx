<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>快乐兴兴 - 账单打印</title>

        <link rel="shortcut icon" href="<?=asset_url('favicon.ico')?>" type="image/x-icon">
        <style>
        /*******************************
                     Reset
        *******************************/


        /* Border-Box */
        *,
        *:before,
        *:after {
          box-sizing: inherit;
        }
        html {
          box-sizing: border-box;
        }

        /* iPad Input Shadows */
        input[type="text"],
        input[type="email"],
        input[type="search"],
        input[type="password"] {
          -webkit-appearance: none;
          -moz-appearance: none;

        /* mobile firefox too! */
        }


        /*******************************
                 Theme Overrides
        *******************************/

        /*! normalize.css v3.0.1 | MIT License | git.io/normalize */
        /**
         * Correct `block` display not defined in IE 8/9.
         */
        /*! normalize.css v3.0.1 | MIT License | git.io/normalize */
        /**
         * 1. Set default font family to sans-serif.
         * 2. Prevent iOS text size adjust after orientation change, without disabling
         *    user zoom.
         */
        html {
          font-family: sans-serif;

        /* 1 */
          -ms-text-size-adjust: 100%;

        /* 2 */
          -webkit-text-size-adjust: 100%;

        /* 2 */
        }
        /**
         * Remove default margin.
         */
        body {
          margin: 0;
        }

        /* HTML5 display definitions
           ========================================================================== */
        /**
         * Correct `block` display not defined for any HTML5 element in IE 8/9.
         * Correct `block` display not defined for `details` or `summary` in IE 10/11 and Firefox.
         * Correct `block` display not defined for `main` in IE 11.
         */
        article,
        aside,
        details,
        figcaption,
        figure,
        footer,
        header,
        hgroup,
        main,
        nav,
        section,
        summary {
          display: block;
        }
        /**
         * 1. Correct `inline-block` display not defined in IE 8/9.
         * 2. Normalize vertical alignment of `progress` in Chrome, Firefox, and Opera.
         */
        audio,
        canvas,
        progress,
        video {
          display: inline-block;

        /* 1 */
          vertical-align: baseline;

        /* 2 */
        }
        /**
         * Prevent modern browsers from displaying `audio` without controls.
         * Remove excess height in iOS 5 devices.
         */
        audio:not([controls]) {
          display: none;
          height: 0;
        }
        /**
         * Address `[hidden]` styling not present in IE 8/9/10.
         * Hide the `template` element in IE 8/9/11, Safari, and Firefox < 22.
         */
        [hidden],
        template {
          display: none;
        }

        /* Links
           ========================================================================== */
        /**
         * Remove the gray background color from active links in IE 10.
         */
        a {
          background: transparent;
        }
        /**
         * Improve readability when focused and also mouse hovered in all browsers.
         */
        a:active,
        a:hover {
          outline: 0;
        }

        /* Text-level semantics
           ========================================================================== */
        /**
         * Address styling not present in IE 8/9/10/11, Safari, and Chrome.
         */
        abbr[title] {
          border-bottom: 1px dotted;
        }
        /**
         * Address style set to `bolder` in Firefox 4+, Safari, and Chrome.
         */
        b,
        strong {
          font-weight: bold;
        }
        /**
         * Address styling not present in Safari and Chrome.
         */
        dfn {
          font-style: italic;
        }
        /**
         * Address variable `h1` font-size and margin within `section` and `article`
         * contexts in Firefox 4+, Safari, and Chrome.
         */
        h1 {
          font-size: 2em;
          margin: 0.67em 0;
        }
        /**
         * Address styling not present in IE 8/9.
         */
        mark {
          background: #ff0;
          color: #000;
        }
        /**
         * Address inconsistent and variable font size in all browsers.
         */
        small {
          font-size: 80%;
        }
        /**
         * Prevent `sub` and `sup` affecting `line-height` in all browsers.
         */
        sub,
        sup {
          font-size: 75%;
          line-height: 0;
          position: relative;
          vertical-align: baseline;
        }
        sup {
          top: -0.5em;
        }
        sub {
          bottom: -0.25em;
        }

        /* Embedded content
           ========================================================================== */
        /**
         * Remove border when inside `a` element in IE 8/9/10.
         */
        img {
          border: 0;
        }
        /**
         * Correct overflow not hidden in IE 9/10/11.
         */
        svg:not(:root) {
          overflow: hidden;
        }

        /* Grouping content
           ========================================================================== */
        /**
         * Address margin not present in IE 8/9 and Safari.
         */
        figure {
          margin: 1em 40px;
        }
        /**
         * Address differences between Firefox and other browsers.
         */
        hr {
          height: 0;
        }
        /**
         * Contain overflow in all browsers.
         */
        pre {
          overflow: auto;
        }
        /**
         * Address odd `em`-unit font size rendering in all browsers.
         */
        code,
        kbd,
        pre,
        samp {
          font-family: monospace, monospace;
          font-size: 1em;
        }

        /* Forms
           ========================================================================== */
        /**
         * Known limitation: by default, Chrome and Safari on OS X allow very limited
         * styling of `select`, unless a `border` property is set.
         */
        /**
         * 1. Correct color not being inherited.
         *    Known issue: affects color of disabled elements.
         * 2. Correct font properties not being inherited.
         * 3. Address margins set differently in Firefox 4+, Safari, and Chrome.
         */
        button,
        input,
        optgroup,
        select,
        textarea {
          color: inherit;

        /* 1 */
          font: inherit;

        /* 2 */
          margin: 0;

        /* 3 */
        }
        /**
         * Address `overflow` set to `hidden` in IE 8/9/10/11.
         */
        button {
          overflow: visible;
        }
        /**
         * Address inconsistent `text-transform` inheritance for `button` and `select`.
         * All other form control elements do not inherit `text-transform` values.
         * Correct `button` style inheritance in Firefox, IE 8/9/10/11, and Opera.
         * Correct `select` style inheritance in Firefox.
         */
        button,
        select {
          text-transform: none;
        }
        /**
         * 1. Avoid the WebKit bug in Android 4.0.* where (2) destroys native `audio`
         *    and `video` controls.
         * 2. Correct inability to style clickable `input` types in iOS.
         * 3. Improve usability and consistency of cursor style between image-type
         *    `input` and others.
         */
        button,
        html input[type="button"],
        input[type="reset"],
        input[type="submit"] {
          -webkit-appearance: button;

        /* 2 */
          cursor: pointer;

        /* 3 */
        }
        /**
         * Re-set default cursor for disabled elements.
         */
        button[disabled],
        html input[disabled] {
          cursor: default;
        }
        /**
         * Remove inner padding and border in Firefox 4+.
         */
        button::-moz-focus-inner,
        input::-moz-focus-inner {
          border: 0;
          padding: 0;
        }
        /**
         * Address Firefox 4+ setting `line-height` on `input` using `!important` in
         * the UA stylesheet.
         */
        input {
          line-height: normal;
        }
        /**
         * It's recommended that you don't attempt to style these elements.
         * Firefox's implementation doesn't respect box-sizing, padding, or width.
         *
         * 1. Address box sizing set to `content-box` in IE 8/9/10.
         * 2. Remove excess padding in IE 8/9/10.
         */
        input[type="checkbox"],
        input[type="radio"] {
          box-sizing: border-box;

        /* 1 */
          padding: 0;

        /* 2 */
        }
        /**
         * Fix the cursor style for Chrome's increment/decrement buttons. For certain
         * `font-size` values of the `input`, it causes the cursor style of the
         * decrement button to change from `default` to `text`.
         */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
          height: auto;
        }
        /**
         * 1. Address `appearance` set to `searchfield` in Safari and Chrome.
         * 2. Address `box-sizing` set to `border-box` in Safari and Chrome
         *    (include `-moz` to future-proof).
         */
        input[type="search"] {
          -webkit-appearance: textfield;

        /* 1 */
        }
        /**
         * Remove inner padding and search cancel button in Safari and Chrome on OS X.
         * Safari (but not Chrome) clips the cancel button when the search input has
         * padding (and `textfield` appearance).
         */
        input[type="search"]::-webkit-search-cancel-button,
        input[type="search"]::-webkit-search-decoration {
          -webkit-appearance: none;
        }
        /**
         * Define consistent border, margin, and padding.
         */
        fieldset {
          border: 1px solid #c0c0c0;
          margin: 0 2px;
          padding: 0.35em 0.625em 0.75em;
        }
        /**
         * 1. Correct `color` not being inherited in IE 8/9/10/11.
         * 2. Remove padding so people aren't caught out if they zero out fieldsets.
         */
        legend {
          border: 0;

        /* 1 */
          padding: 0;

        /* 2 */
        }
        /**
         * Remove default vertical scrollbar in IE 8/9/10/11.
         */
        textarea {
          overflow: auto;
        }
        /**
         * Don't inherit the `font-weight` (applied by a rule above).
         * NOTE: the default cannot safely be changed in Chrome and Safari on OS X.
         */
        optgroup {
          font-weight: bold;
        }

        /* Tables
           ========================================================================== */
        /**
         * Remove most spacing between table cells.
         */
        table {
          border-collapse: collapse;
          border-spacing: 0;
        }
        td,
        th {
          padding: 0;
        }


        /*******************************
                 Site Overrides
        *******************************/

            html, body {
                font-size: 15px;
                font-family: 'Helvetica Neue',Arial,Helvetica,sans-serif;
            }

            .ui.table {
              width: 100%;
              background: #FFFFFF;
              margin: 1em 0em;
              border: 1px solid rgba(34, 36, 38, 0.15);
              box-shadow: none;
              border-radius: 0.28571429rem;
              text-align: left;
              color: rgba(0, 0, 0, 0.87);
              border-collapse: separate;
              border-spacing: 0px;
            }
            .ui.table:first-child {
              margin-top: 0em;
            }
            .ui.table:last-child {
              margin-bottom: 0em;
            }


            /*******************************
                         Parts
            *******************************/


            /* Table Content */
            .ui.table th,
            .ui.table td {
              -webkit-transition: background 0.1s ease, color 0.1s ease;
              transition: background 0.1s ease, color 0.1s ease;
            }

            /* Headers */
            .ui.table thead {
              box-shadow: none;
            }
            .ui.table thead th {
              cursor: auto;
              background: #F9FAFB;
              text-align: inherit;
              color: rgba(0, 0, 0, 0.87);
              padding: 0.92857143em 0.78571429em;
              vertical-align: inherit;
              font-style: none;
              font-weight: bold;
              text-transform: none;
              border-bottom: 1px solid rgba(34, 36, 38, 0.1);
              border-left: none;
            }
            .ui.table thead tr > th:first-child {
              border-left: none;
            }
            .ui.table thead tr:first-child > th:first-child {
              border-radius: 0.28571429rem 0em 0em 0em;
            }
            .ui.table thead tr:first-child > th:last-child {
              border-radius: 0em 0.28571429rem 0em 0em;
            }
            .ui.table thead tr:first-child > th:only-child {
              border-radius: 0.28571429rem 0.28571429rem 0em 0em;
            }

            /* Footer */
            .ui.table tfoot {
              box-shadow: none;
            }
            .ui.table tfoot th {
              cursor: auto;
              border-top: 1px solid rgba(34, 36, 38, 0.15);
              background: #F9FAFB;
              text-align: inherit;
              color: rgba(0, 0, 0, 0.87);
              padding: 0.78571429em 0.78571429em;
              vertical-align: middle;
              font-style: normal;
              font-weight: normal;
              text-transform: none;
            }
            .ui.table tfoot tr > th:first-child {
              border-left: none;
            }
            .ui.table tfoot tr:first-child > th:first-child {
              border-radius: 0em 0em 0em 0.28571429rem;
            }
            .ui.table tfoot tr:first-child > th:last-child {
              border-radius: 0em 0em 0.28571429rem 0em;
            }
            .ui.table tfoot tr:first-child > th:only-child {
              border-radius: 0em 0em 0.28571429rem 0.28571429rem;
            }

            /* Table Row */
            .ui.table tr td {
              border-top: 1px solid rgba(34, 36, 38, 0.1);
            }
            .ui.table tr:first-child td {
              border-top: none;
            }

            /* Table Cells */
            .ui.table td {
              padding: 0.78571429em 0.78571429em;
              text-align: inherit;
            }

            /* Icons */
            .ui.table > .icon {
              vertical-align: baseline;
            }
            .ui.table > .icon:only-child {
              margin: 0em;
            }

            /*--------------
             Text Alignment
            ---------------*/

            .ui.table[class*="left aligned"],
            .ui.table [class*="left aligned"] {
              text-align: left;
            }
            .ui.table[class*="center aligned"],
            .ui.table [class*="center aligned"] {
              text-align: center;
            }
            .ui.table[class*="right aligned"],
            .ui.table [class*="right aligned"] {
              text-align: right;
            }

            .ui.message {
              position: relative;
              min-height: 1em;
              margin: 1em 0em;
              background: #F8F8F9;
              padding: 1em 1.5em;
              line-height: 1.4285em;
              color: rgba(0, 0, 0, 0.87);
              -webkit-transition: opacity 0.1s ease, color 0.1s ease, background 0.1s ease, box-shadow 0.1s ease;
              transition: opacity 0.1s ease, color 0.1s ease, background 0.1s ease, box-shadow 0.1s ease;
              border: 1px solid #DDDDDD;
            }
            .ui.message:first-child {
              margin-top: 0em;
            }
            .ui.message:last-child {
              margin-bottom: 0em;
            }

            .row {
                margin-left: -15px;
                margin-right: -15px;
            }

            .col-md-1,
            .col-md-2,
            .col-md-3,
            .col-md-4,
            .col-md-5,
            .col-md-6,
            .col-md-7,
            .col-md-8,
            .col-md-9,
            .col-md-10,
            .col-md-11,
            .col-md-12 {
              position: relative;
              min-height: 1px;
              padding-left: 15px;
              padding-right: 15px;
            }
            .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
              float: left;
            }

            .col-md-1,
            .col-md-10,
            .col-md-11,
            .col-md-12,
            .col-md-2,
            .col-md-3,
            .col-md-4,
            .col-md-5,
            .col-md-6,
            .col-md-7,
            .col-md-8,
            .col-md-9 {
                float: left;
            }

            .col-md-12 {
                width: 100%;
            }

            .col-md-11 {
                width: 91.66666667%;
            }

            .col-md-10 {
                width: 83.33333333%;
            }

            .col-md-9 {
                width: 75%;
            }

            .col-md-8 {
                width: 66.66666667%;
            }

            .col-md-7 {
                width: 58.33333333%;
            }

            .col-md-6 {
                width: 50%;
            }

            .col-md-5 {
                width: 41.66666667%;
            }

            .col-md-4 {
                width: 33.33333333%;
            }

            .col-md-3 {
                width: 25%;
            }

            .col-md-2 {
                width: 16.66666667%;
            }

            .col-md-1 {
                width: 8.33333333%;
            }

            .col-md-pull-12 {
                right: 100%;
            }

            .col-md-pull-11 {
                right: 91.66666667%;
            }

            .col-md-pull-10 {
                right: 83.33333333%;
            }

            .col-md-pull-9 {
                right: 75%;
            }

            .col-md-pull-8 {
                right: 66.66666667%;
            }

            .col-md-pull-7 {
                right: 58.33333333%;
            }

            .col-md-pull-6 {
                right: 50%;
            }

            .col-md-pull-5 {
                right: 41.66666667%;
            }

            .col-md-pull-4 {
                right: 33.33333333%;
            }

            .col-md-pull-3 {
                right: 25%;
            }

            .col-md-pull-2 {
                right: 16.66666667%;
            }

            .col-md-pull-1 {
                right: 8.33333333%;
            }

            .col-md-pull-0 {
                right: auto;
            }

            .col-md-push-12 {
                left: 100%;
            }

            .col-md-push-11 {
                left: 91.66666667%;
            }

            .col-md-push-10 {
                left: 83.33333333%;
            }

            .col-md-push-9 {
                left: 75%;
            }

            .col-md-push-8 {
                left: 66.66666667%;
            }

            .col-md-push-7 {
                left: 58.33333333%;
            }

            .col-md-push-6 {
                left: 50%;
            }

            .col-md-push-5 {
                left: 41.66666667%;
            }

            .col-md-push-4 {
                left: 33.33333333%;
            }

            .col-md-push-3 {
                left: 25%;
            }

            .col-md-push-2 {
                left: 16.66666667%;
            }

            .col-md-push-1 {
                left: 8.33333333%;
            }

            .col-md-push-0 {
                left: auto;
            }

            .col-md-offset-12 {
                margin-left: 100%;
            }

            .col-md-offset-11 {
                margin-left: 91.66666667%;
            }

            .col-md-offset-10 {
                margin-left: 83.33333333%;
            }

            .col-md-offset-9 {
                margin-left: 75%;
            }

            .col-md-offset-8 {
                margin-left: 66.66666667%;
            }

            .col-md-offset-7 {
                margin-left: 58.33333333%;
            }

            .col-md-offset-6 {
                margin-left: 50%;
            }

            .col-md-offset-5 {
                margin-left: 41.66666667%;
            }

            .col-md-offset-4 {
                margin-left: 33.33333333%;
            }

            .col-md-offset-3 {
                margin-left: 25%;
            }

            .col-md-offset-2 {
                margin-left: 16.66666667%;
            }

            .col-md-offset-1 {
                margin-left: 8.33333333%;
            }

            .col-md-offset-0 {
                margin-left: 0;
            }

            .clearfix:after,
            .clearfix:before,
            .container-fluid:after,
            .container-fluid:before,
            .container:after,
            .container:before,
            .row:after,
            .row:before {
                content: " ";
                display: table;
            }

            .clearfix:after,
            .container-fluid:after,
            .container:after,
            .row:after {
                clear: both;
            }

            /*-------------------
                   Aligned
            --------------------*/

            .flexbox {
                display: -webkit-flex;

                [class*="top aligned"] {
                  -webkit-align-self: flex-start;
                          align-self: flex-start;
                }

                [class*="middle aligned"] {
                  -webkit-align-self: center;
                          align-self: center;
                }
                [class*="bottom aligned"] {
                  -webkit-align-self: flex-end;
                          align-self: flex-end;
                }
            }

            .center-block {
              display: block;
              margin-left: auto;
              margin-right: auto;
            }
            .pull-right {
              float: right !important;
            }
            .pull-left {
              float: left !important;
            }

            .text-left {
                text-align: left;
            }

            .text-right {
                text-align: right;
            }

            .text-center {
                text-align: center;
            }

            .text-justify {
                text-align: justify;
            }

            .text-nowrap {
                white-space: nowrap;
            }

            .text-lowercase {
                text-transform: lowercase;
            }

            .text-uppercase {
                text-transform: uppercase;
            }

            .text-capitalize {
                text-transform: capitalize;
            }

            .text-muted {
                color: #777777;
            }

            .text-primary {
                color: #337ab7;
            }

            a.text-primary:focus,
            a.text-primary:hover {
                color: #286090;
            }

            .text-success {
                color: #3c763d;
            }

            a.text-success:focus,
            a.text-success:hover {
                color: #2b542c;
            }

            .text-info {
                color: #31708f;
            }

            a.text-info:focus,
            a.text-info:hover {
                color: #245269;
            }

            .text-warning {
                color: #8a6d3b;
            }

            a.text-warning:focus,
            a.text-warning:hover {
                color: #66512c;
            }

            .text-danger {
                color: #a94442;
            }

            a.text-danger:focus,
            a.text-danger:hover {
                color: #843534;
            }

            .ui.segment {
              position: relative;
              background: #FFFFFF;
              margin: 1rem 0em;
              padding: 1em 1em;
              border: 1px solid rgba(34, 36, 38, 0.15);
            }
            .ui.segment:first-child {
              margin-top: 0em;
            }
            .ui.segment:last-child {
              margin-bottom: 0em;
            }

            .klxx-order-print {
                width: 900px;
                margin: 0 auto;
            }

            .klxx-order-print .logo img {
                max-width: 300px;
            }

            .klxx-order-print .row {
                margin-top: 10px;
                margin-bottom: 10px;
            }

        </style>
    </head>
    <body>
        <div class="klxx-order-print">
            <div class="logo center-block text-center">
                <img src="/static/img/logo.png" />
            </div>

            <div class="ui segment">
                <div class="ui dividing header">账单信息</div>

                <table class="ui celled table">
                    <thead>
                        <tr>
                            <th>客户</th>
                            <th>应收</th>
                            <th>实收</th>
                            <th>欠款</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>{{ $invoice->customer }}</td>
                            <td>{{ $invoice->total_sales }}元</td>
                            <td>{{ $invoice->total_paid }}元</td>
                            <td>{{ $invoice->total_sales - $invoice->total_paid }}元</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="ui segment">
                <div class="ui dividing header">货单列表</div>

                <table class="ui celled table">
                    <thead>
                        <tr>
                            <th>编号</th>
                            <th>客户</th>
                            <th>金额</th>
                            <th>已付</th>
                            <th>欠款</th>
                            <th>日期</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->customer }}</td>
                            <td>{{ $order->total }}元</td>
                            <td>{{ $order->paid }}元</td>
                            <td>{{ $order->total - $order->paid}}元</td>
                            <td width="180">{{ $order->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="2">总计：</th>
                            <th>{{ $invoice->total_sales }}元</th>
                            <th>{{ $invoice->total_paid }}元</th>
                            <th>{{ $invoice->total_sales - $invoice->total_paid  }}元</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </body>
</html>
