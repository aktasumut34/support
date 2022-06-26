<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>
        html {
            padding: 0;
            margin: 0;
            font-family:"DeJaVu Sans Mono",monospace;
        }

        section#top-bar {
            background: #dde1e3;
            width: 100%;
        }

        section#top-bar table.header {
            width: 100%;
            border-collapse: collapse;
            padding: 30px 25px 0px 25px;
        }

        section#top-bar table.header .left {
            text-align: left;
        }

        section#top-bar table.header .left table.identity .logo {
            width: 150px;
        }

        section#top-bar table.header .left table.identity .logo img {
            width: 128px;
        }

        section#top-bar table.header .left table.identity .details p {
            margin: 0;
        }

        section#top-bar table.header .left table.identity .details p {
            color: #9f9f9f;
            font-size: 10px;
        }

        section#top-bar table.header .left table.identity .details .title {
            font-weight: semibold;
            color: #888;
            font-size: 14px;
            margin-bottom: 2px;
        }

        section#top-bar table.header .right {
            text-align: right;
            color: #feffff;
            font-size: 24px;
            font-weight: bold;
            vertical-align: bottom;
            text-transform: lowercase;
        }

        section#top-bar table.boxes {
            width: 100%;
            border-spacing: 5px;
            padding: 0px 25px 20px 25px;
        }

        section#top-bar table.boxes .top-box {
            background: #bdc4c8;
            color: #f7f7f8;
            height: 60px;
            text-align: center;
            vertical-align: middle;
        }

        section#top-bar table.boxes .top-box p {
            margin: 0;
        }

        section#top-bar table.boxes .top-box p.title {
            font-size: 0.7em;
            text-transform: lowercase;
            font-weight: normal;
        }

        section#top-bar table.boxes .top-box.to {
            text-align: left;
            vertical-align: baseline;
            padding: 10px;
        }

        section#top-bar table.boxes .top-box.to p.full-name,
        section#top-bar table.boxes .top-box p.content {
            font-size: 14px;
            font-weight: semibold;
        }

        section#top-bar table.boxes .top-box.red-box {
            background: #db453b;
        }

        section#top-bar table.boxes .top-box.green-box {
            background: #45db3b;
        }

        .w-50 {
            width: 40%;
        }

        .w-25 {
            width: 30%;
        }

        table * {
            vertical-align: top;
        }

        table.products {
            width: 100%;
            padding: 0px 25px 0px 25px;
            margin-top: 15px;
        }

        table.products th {
            text-align: right;
            background-color: #bdc4c8;
            color: #f7f7f8;
            text-transform: lowercase;
            padding: 10px 5px;
        }

        table.products td {
            padding: 10px 5px;
            color: #a7a6a8;
        }

        table.products td.product .title {
            color: #858585;
            font-size: 14px;
        }

        table.products td span.description {
            display: block;
            font-size: 10px;
        }

        table.products th.product,
        table.products th.price,
        table.products th.qty {
            border-right: 2px solid #dde0e3;
        }

        table.products td.product,
        table.products td.price,
        table.products td.qty {
            border-right: 2px solid #dcdfe2;
        }

        table.products td.price,
        table.products td.qty,
        table.products td.total,
        table.products td.product {
            font-size: .8em;
            border-bottom: 1px solid #bec4c7;
        }

        table.products td.price,
        table.products td.qty,
        table.products td.total {
            text-align: right;
        }

        table.totals-table {
            width: 100%;
            padding: 5px 25px 0px 25px;
            border-spacing: 0px;
        }

        table.totals-table tr.totals {
            text-align: right;
        }

        table.totals-table tr.totals td {
            text-align: right;
            background-color: #bdc4c8;
            color: #f7f7f8;
            text-transform: lowercase;
            padding: 10px 10px;
            font-size: .8em;
            border-top: 2px solid #dcdfe2;
        }
        table.totals-table tr.totals td:first-child {
            border-top: none;
        }
        table.totals-table tr:first-child.totals td {
            border-top: 3px solid #bdc4c8;
        }
        table.totals-table tr.totals .totals-total {
            font-size: 14px;
        }

        table.totals-table tr.totals td.empty {
            background: unset;
            width: 60%;
        }

        table.totals-table tr.totals td.title {
            border-right: 2px solid #dcdfe2;
            width: 25.5%;
        }

        table.totals-table tr.totals td.totals-total {
            width: 14.5%;
        }

        #paid-seal {
            color: #fff;
            background: rgba(69, 219, 59, .4);
            font-size: 64px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: rotate(-45deg) translate(-50%, -50%);
            text-align: center;
            padding: 0 10px;
        }
    </style>
</head>

<body>
    <section id="top-bar">
        <table class="header">
            <tr>
                <td class="left">
                    <table class="identity">
                        <tr>
                            <td class="logo">
                                <img src="{{public_path('logo.png')}}"
                                    class="header-brand-img dark-logo" alt="logo">
                            </td>
                            <td class="details">
                                <p class="title">Elit Pack</p>
                                <p>info@elitpack.com.tr</p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="right">spare part request</td>
            </tr>
        </table>

        <table class="boxes">
            <tr>
                <td rowspan="2" colspan="2" class="top-box w-50 to">
                    <p class="full-name">{{ $sparePartRequest->customer->firstname . ' ' . $sparePartRequest->customer->lastname }}</p>
                    <p class="full-name">{{ $sparePartRequest->customer->company_name }}</p>
                    <p class="full-name">{{ $sparePartRequest->customer->company_address }}</p>
                </td>
                <td class="top-box w-25">
                    <p class="title">{{ 'request number' }}</p>
                    <p class="content">{{ $sparePartRequest->request_no }}</p>
                </td>
                <td class="top-box w-25">
                    <p class="title">{{ 'status' }}</p>
                    <p class="content">
                        {{ $sparePartRequest->status }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="top-box w-25">
                    <p class="title">created at</p>
                    <p class="content">
                        {{ \Carbon\Carbon::parse($sparePartRequest->created_at)->format('m/d/Y') }}
                    </p>
                </td>
                <td class="top-box w-25">
                    <p class="title">last action</p>
                    <p class="content">
                        {{ \Carbon\Carbon::parse($sparePartRequest->updated_at)->format('m/d/Y') }}
                    </p>
                </td>
            </tr>
        </table>
    </section>
    <section>
        <table class="products" border="0" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="product" style="width: 25%; text-align: left;">
                        {{ 'machine' }}
                    </th>
                    <th class="qty" style="width: 14%">{{ 'serial number' }}</th>
                    <th class="product" style="width: 25%">{{ 'spare part' }}</th>
                    <th class="qty" style="width: 12%">{{ 'quantity' }}</th>
                    <th class="price" style="width: 12%">{{ 'price' }}</th>
                    <th class="total" style="width: 12%">{{ 'total' }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sparePartRequest->items as $item)
                    <tr>
                        @if ($item->customerLineupMachine)
                            <td class="product">
                                <span class="title">{{ $item->customerLineupMachine->machine->name }}</span>
                                <span class="description"> {{ $item->customerLineupMachine->machine->code }}</span>
                            </td>
                        @endif
                        <td class="qty">{{ $item->customerLineupMachine->serial_number }}</td>
                        <td class="product">
                            <span class="title">{{ $item->sparePart->name }}</span>
                            <span class="description"> {{ $item->sparePart->code }}</span>
                        </td>
                        <td class="qty">
                            {{ $item->quantity }}
                        </td>
                        <td class="price">
                           ₺ {{ $item->price }}
                        </td>
                        <td class="total">
                           ₺ {{ number_format($item->quantity * $item->price,2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table class="totals-table">
            <tr class="totals">
                <td class="empty" colspan="3"></td>
                <td class="title">
                    {{ 'total' }}
                </td>
                <td class="totals-total">
                    ₺ {{ number_format($sparePartRequest->total, 2) }}
                </td>
            </tr>
            <tr class="totals">
                <td class="empty" colspan="3"></td>
                <td class="title">
                    {{ 'discounted total' }}
                </td>
                <td class="totals-total">
                    ₺ {{ number_format($sparePartRequest->discounted_total, 2) }}
                </td>
            </tr>
        </table>
    </section>

</body>

</html>
