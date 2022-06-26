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
                <td class="right">ticket</td>
            </tr>
        </table>

        <table class="boxes">
            <tr>
                <td rowspan="2" colspan="2" class="top-box w-50 to">
                    <p class="full-name">{{ $ticket->cust->firstname . ' ' . $ticket->cust->lastname }}</p>
                    <p class="full-name">{{ $ticket->cust->company_name }}</p>
                    <p class="full-name">{{ $ticket->cust->company_address }}</p>
                </td>
                <td class="top-box w-25">
                    <p class="title">{{ 'ticket number' }}</p>
                    <p class="content">{{ $ticket->ticket_id }}</p>
                </td>
                <td class="top-box w-25">
                    <p class="title">{{ 'status' }}</p>
                    <p class="content">
                        {{ $ticket->status }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="top-box w-25">
                    <p class="title">created at</p>
                    <p class="content">
                        {{ \Carbon\Carbon::parse($ticket->created_at)->format('m/d/Y') }}
                    </p>
                </td>
                <td class="top-box w-25">
                    <p class="title">last action</p>
                    <p class="content">
                        {{ \Carbon\Carbon::parse($ticket->updated_at)->format('m/d/Y') }}
                    </p>
                </td>
            </tr>
        </table>
    </section>
    <style>
        .from-customer, .from-admin{
            margin: 10px;
            padding: 10px;
            width: 80%;
            font-size: 12px !important;
            color: white;
            border-radius: 1em;
        }
        .from-admin *, .from-customer * {
            padding: 0;
            margin: 0;
        }
        .from-admin {
            background-color: #EC9419;
            text-align: right;
            margin-left: 15%;
        }
        .from-customer {
            background-color: #52C85E;
            margin-right: 15%;
        }
        .comment-details {
            margin-top: 5px !important;
            font-size: 10px !important;
            color: #f0f0f0;
        }
    </style>
    <section>
        <div class='conversation'>
            <div class='from-customer'>
                <div>
                    {!! $ticket->message !!}
                    <div class='comment-details'>
                        <div>
                            <div>{{ \Carbon\Carbon::parse($ticket->created_at)->format('d.m.Y H:i') }}</div>
                            <div>
                                {{ $ticket->cust->firstname . ' ' . $ticket->cust->lastname }}
                            </div>
                        </div>
                    </div>
                </div>
    </div>
            @foreach ($ticket->comms as $comment)
                <div class=" @if($comment->cust_id) from-customer @else from-admin @endif ">
                    <div>
                        {!! $comment->comment !!}
                        <div class='comment-details'>
                            <div>
                                <div>{{ \Carbon\Carbon::parse($comment->created_at)->format('d.m.Y H:i') }}</div>
                                <div>
                                    @if ($comment->cust_id)
                                        {{ $ticket->cust->firstname . ' ' . $ticket->cust->lastname }}
                                    @else
                                        {{ $comment->user->firstname . ' ' . $comment->user->lastname }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
    </div>
    </section>
</body>

</html>
