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
                    <a>Payments</a>
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

                @forelse ($payments as $payment)
                
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->store->name }}</td>
                    <td>{{ $payment->total }}</td>
                    <td>{{ $payment->application_dues }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->created_at->format('Y-m-d') }}</td>
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