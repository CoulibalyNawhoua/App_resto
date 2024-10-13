<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bon de commande</title>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:100,300,400,900,700,500,300,100);
        *{
            margin: 0;
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
        }
        body{
            /* background: #E0E0E0; */
            font-family: 'Roboto', sans-serif;
        }
        ::selection {background: #f31544; color: #FFF;}
        ::moz-selection {background: #f31544; color: #FFF;}
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .col-left {
            float: left;
        }
        .col-right {
            float: right;
        }
        h1{
            font-size: 1.5em;
            color: #444;
        }
        h2{font-size: .9em;}
        h3{
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }
        p{
            font-size: .75em;
            color: #666;
            line-height: 1.2em;
        }
        a {
            text-decoration: none;
            color: #00a63f;
        }

        #invoiceholder{
            width:100%;
            padding: 50px 0;
        }
        #invoice{
            position: relative;
            margin: 0 auto;
            width: 700px;
            background: #FFF;
        }

        [id*='invoice-']{
            padding: 20px;
        }

        #invoice-top{border-bottom: 2px solid black; margin-top: 5px; width: 100%}

        .logo{
            display: inline-block;
            vertical-align: middle;
            width: 110px;
            overflow: hidden;
        }
        .info{
            display: inline-block;
            vertical-align: middle;
            margin-left: 20px;
        }
        .logo img,
        .clientlogo img {
            width: 100%;
        }
        /* .clientlogo{
            display: inline-block;
            vertical-align: middle;
            width: 50px;
        } */
        .clientinfo {
            display: inline-block;
            vertical-align: middle;
            /* margin-left: 20px */
        }
        .title{
            float: right;
        }
        .title p{text-align: right;}
        #message{margin-bottom: 30px; display: block;}
        h2 {
            margin-bottom: 5px;
            color: #444;
        }
        .col-right td {
            color: #666;
            padding: 5px 8px;
            border: 0;
            font-size: 0.75em;
            border-bottom: 1px solid #eeeeee;
        }
        .col-right td label {
            margin-left: 5px;
            font-weight: 600;
            color: #444;
        }

        .col-left td {
            color: #666;
            padding: 5px 8px;
            border: 0;
            font-size: 0.75em;
            border-bottom: 1px solid #eeeeee;
        }
        .col-left td label {
            margin-left: 5px;
            font-weight: 600;
            color: #444;
        }
        .cta-group a {
            display: inline-block;
            padding: 7px;
            border-radius: 4px;
            background: rgb(196, 57, 10);
            margin-right: 10px;
            min-width: 100px;
            text-align: center;
            color: #fff;
            font-size: 0.75em;
        }
        .cta-group .btn-primary {
            background: #00a63f;
        }
        .cta-group.mobile-btn-group {
            display: none;
        }
        table{
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid;
        }
        td{
            padding: 10px;
            border-bottom: 1px solid #cccaca;
            font-size: 0.70em;
            text-align: left;
        }

        .tabletitle th {
            border-bottom: 2px solid #ddd;
            text-align: left;
        }
        .tabletitle th:nth-child(2) {
            text-align: left;
        }
        th {
            font-size: 0.7em;
            text-align: left;
            padding: 5px 10px;
        }
        .item{width: 50%;}
        .list-item td {
            text-align: left;
        }
        .list-item td:nth-child(2) {
            text-align: left;
        }
        .total-row th,
        .total-row td {
            text-align: left;
            font-weight: 700;
            font-size: .75em;
            border: 0 none;
        }

        footer {
            border-top: 1px solid #eeeeee;;
            padding: 10px 10px;
        }

        @media screen and (max-width: 767px) {
            h1 {
                font-size: .9em;
            }
            #invoice {
                width: 100%;
            }
            #message {
                margin-bottom: 20px;
            }
            [id*='invoice-'] {
                padding: 20px 10px;
            }
            .logo {
                width: 140px;
            }
            .title {
                float: none;
                display: inline-block;
                vertical-align: middle;
                margin-left: 40px;
            }
            .title p {
                text-align: left;
            }
            .col-left,
            .col-right {
                width: 100%;
            }
            /* .table {
                margin-top: 20px;
            } */
            #table {
                white-space: nowrap;
                overflow: auto;
            }
            td {
                white-space: normal;
            }
            .cta-group {
                text-align: center;
            }
            .cta-group.mobile-btn-group {
                display: block;
                margin-bottom: 20px;
            }
            /*==================== Table ====================*/
            .table-main {
                border: 0 none;
            }
            .table-main thead {
                border: none;
                clip: rect(0 0 0 0);
                height: 1px;
                margin: -1px;
                overflow: hidden;
                padding: 0;
                position: absolute;
                width: 1px;
            }
            .table-main tr {
                border-bottom: 2px solid #eee;
                display: block;
                margin-bottom: 20px;
            }
            .table-main td {
                font-weight: 700;
                display: block;
                padding-left: 40%;
                max-width: none;
                position: relative;
                border: 1px solid #cccaca;
                text-align: left;
            }
            .table-main td:before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                font-weight: normal;
                text-transform: uppercase;
            }
            .total-row th {
                display: none;
            }
            .total-row td {
                text-align: left;
            }
            footer {text-align: center;}
        }

    </style>
</head>
<body>
<div id="invoiceholder">
    <div id="invoice">
        <div id="invoice-top">
            <div class="logo"><img src="{{ $image }}" alt="Logo" /></div>
            <div class="title">
                <h1>LIVRAISON N° <span class="invoiceVal invoice_num">{{ $delivery->reference }}</span></h1>
                <p>Date création: <span id="invoice_date">{{ Date::parse($delivery->add_date)->locale('fr')->format('l j F Y H:m:s') }}</span><br>
                </p>
            </div>
        </div>
        <div id="invoice-mid">

            <div class="clearfix">
                <div class="col-left">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td><span>Dépôt déstocké</span>
                                <label >
                                    {{ $order->destination->name }}
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td><span>Date de préparation</span>
                                <label >
                                    @if($delivery->preparation_date)
                                        {{ Date::parse($delivery->preparation_date )->locale('fr')->format('l j F Y')}}
                                    @endif
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @if($delivery->delivery_status == 1)
                                    <span style="color: orangered">Livraison en attente</span>
                                @endif

                                @if($delivery->delivery_status == 2)
                                    <span style="color: #00a63f">Livré</span>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-right">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td><span>Dépôt receveur</span>
                                <label >
                                    {{ $order->entite->name }}
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td><span>Date de livraison</span>
                                <label >
                                    {{ Date::parse($delivery->delivery_date)->locale('fr')->format('l j F Y')  }}
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td><span>Utilisateur</span>
                                <label >
                                    {{ $delivery->auteur->first_name }} {{ $delivery->auteur->last_name }}
                                </label>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="invoice-mid">

            <div class="clearfix">
                <div class="col-left">
                    <table class="table" style="border: none">
                        <tbody>
                        <tr>
                            <td><span>COMMANDE N°</span>
                                <label >
                                    {{ $order->reference }}
                                </label>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-right">
                </div>
            </div>
        </div>


        <div id="invoice-bot">
            <div id="table">
                <table class="table-main">
                    <thead>
                    <tr class="tabletitle">
                        <th>Produit</th>
                        <th>Unité</th>
                        <th>Qté</th>
                    </tr>
                    </thead>
                    @foreach ($deliveryProduct as $item)
                        <tr class="list-item">
                            <td data-label="Article" class="tableitem">
                                {{ $item->produit->nom_produit }} <br>
                            </td>
                            <td data-label="Quantité" class="tableitem">{{ $item->product_unit->unite->name }}</td>
                            <td data-label="Quantité" class="tableitem">{{ number_format($item->quantity_delivered) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>



