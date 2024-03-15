<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta content="LabPlus is an online application for Laboratory test requests" name="description">
    <meta content="MUH" name="Makerere University Hospital"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- App favicon -->
    <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">
    <!-- third party css -->
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="light-style">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
    <style type="text/css">
        .wrapper {
        width: 70%;
        height: auto;
        margin: 10px auto;
        border: 1px solid #cbcbcb;
        background: white;
      }
         @media print {
                 .no-print{
                     display:none;
                 }
              }

      .button {
        background-color: #4CAF50; /* Green */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
      }

        footer {
        font-size: 12px;
        color: #000;
        text-align: center;
        margin-top:  4px;
      }
      #bottom {
                position: absolute;
                bottom:30;
                /* left:0;                          */
            }
        .text_centered {
        position: absolute;
        top: 72%;
        left: 26%;
        transform: translate(-50%, -50%);
        color: red
        }
        header {
        font-size: 12px;
        color: #000;
        text-align: center;
        margin-bottom: 12px
      }

      @page {
        size: A4;
        margin: 11mm 17mm 17mm 17mm;
        @bottom-right {
          content: counter(page) " of " counter(pages);
         }
      }

      .doc {
        writing-mode: vertical-rl;
         position: absolute;
        left: -15px;
        bottom: 0px;
        z-index: 1;
      }
      .photo {
        display: block;
        border: 2px solid #ccc;
         border-radius: 4px;
        margin-left: auto;
        width: 120px;
        height: 160px;
        }
      @media print {
        footer {
          position: fixed;
          bottom: 0;
        }
        .text_centered {
        position: absolute;
        top: 69%;
        left: 19%;
        /* transform: translate(-50%, -50%); */
        color: red
        }
      .wrapper{
         width: 100%;
        height: auto;
        margin: 2px auto;
        margin-top: -12px;
        border: 0px ;
        background: white;
        }
        .button {
          display: none;
        }
      header {
          position: fixed;
          top: 0;
           text-align: right;
        }

        .doc {
        writing-mode: vertical-rl;
         position:  fixed;
        left: -15px;
        bottom: 16px;
        z-index: 1;
      }
        .content-block, p {
          page-break-inside: avoid;
        }

        html, body {
          width: 210mm;
          height: 297mm;
        }
      }
      </style>
      <script>
    //   window.print();
    //   window.onmousemove = function() {
    //   window.close();}
     </script>
</head>
<body style="background-color: #fff">
    <!-- end row-->

            <section class="wrapper" id="content">
                <!-- title row -->
                <div class="row">
                    <p style="text-align:center;"><img src="{{url('assets/images/icons/mms.png')}}" alt="ACB Logo" width="110px" style="vertical-align:middle;"></p>
                    <h4 style="text-align:center; font-family:times;">{{ $bizname }}</h4><br>
                    <h6 style="text-align:center; font-family:times; color:rgb(15, 113, 240)">TEL:<b>{{$bizcontact}}</b> EMAIL: <b>{{$bizemail}}</b> </h6>
                    <hr style="height:2px; width:100%; color:rgb(55, 52, 52);">
                </div>

                @yield('content')

                <footer>
                    <table width="100%" style="margin-top: -16px">
                
                        <tr>
                            <td> <p style="text-align:center; font-size:10px; color:#4CAF50">Printed By: <font>{{ Auth::user()->name }} </font></p></td>
                            <td> <p style="text-align:center; font-size:10px; color:#4CAF50"> Print Date: {{date('l d-M-Y H:i:s')}}</font></p></td>
                        </tr>
                    </table>
                </footer>
              </section>


         <button class="button btn-info" onclick="window.print()">Print</button>

        <Script>
            let doc = new jsPDF('p','pt','a4');
            doc.setFontSize(22);
            doc.setTextColor(255, 0, 0);
            doc.text(20, 20, 'This is a title');
            doc.margin(1);
            doc.setFontSize(16);
            doc.setTextColor(0, 255, 0);
            doc.text(20, 30, 'This is some normal sized text underneath.');
            doc.addHTML(document.body,function() {
                doc.save('Print');
            });
             </Script>
</body>
</html>
