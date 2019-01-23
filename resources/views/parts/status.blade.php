@if (session('status'))
@if(is_array(session('status')))
@php
$status = session('status');
$message = $status[0];

$type = $status[1];

@endphp
<script>
    showInfoMessage('{{ $message }}', '{{$type}}');
</script>
@else
<script>
    showInfoMessage('{{ session('status') }}', 'green');
</script>
@endif
@endif