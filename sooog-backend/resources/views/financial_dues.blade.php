<!DOCTYPE html>
<html>
<head>
    <title>orders</title>
    <style type="text/css">
      * { font-family: DejaVu Sans, sans-serif; }
        #contacts {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
      }
      #contacts td, #contacts th {
          border: 1px solid #ddd;
          padding: 8px;
      }
      #contacts tr:nth-child(even){background-color: #f2f2f2;}
      #contacts tr:hover {background-color: #ddd;}
      #contacts th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #a1a7a7;
          color: #111;
      }
      .main-container{
        float: none;
        position: relative;
        background-color: #eee;
        padding: 8px;
        border: 1px solid #ddd;
        margin: 0 auto;
    }
    .table-container{
        width: 75%;
        display: table;
    }
    .heading-item a{
        text-align: right;
    }
    .heading {padding: 10px 0px;}
    .heading p {font-size:0;}
    .heading p span { width:50%; display:inline-block; }
    .heading p span.align-right { text-align:right; }
span a { font-size:16px; }
</style>
</head>
<body>
    <div class="main-container">
        <div class="heading">
            <p>
                <span>
                    <a>Financial Dues</a>
                </span>
            </p>
        </div>
        <div class="table-container">
            <table id="contacts">
                <tr>
                    <th>No</th>
                    <th>Store</th>
                    <th>Amount before deduction of commission</th>
                    <th>commission</th>
                    <th>Amount after deduction of commission</th>
                    <th>Date</th>
                </tr>

                @forelse ($orders as $order)
                <?php 
                  

                  $refund_period = setting('refund_period');
                  $refund_period = $refund_period ? : 10;
                  $date = $order->created_at->addDays($refund_period);
                ?>
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->store->name }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->application_dues }}</td>
                    <td>{{ number_format((float)($order->total - $order->application_dues), 2, '.', '') }}</td>
                    <td>{{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="6"> no data</td>
                </tr>
                @endforelse
            </table>
        </div>     
    </div>
</body>
</html>