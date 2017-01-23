<h1>Invoice</h1>

name : {{$investment->user->first_name}} {{$investment->user->last_name}}
<br>

Project : {{$investment->project->title}}
<br>

Amount: AUD {{$investment->amount}}.00
<br>

Date: {{ $investment->created_at->toFormattedDateString() }}