<a href="<?= route('setlocale', ['lang' => 'en']) ?>">
    @if($item->hasLocaleName('en'))<span class="glyphicon glyphicon-ok"></span>@endif English
</a>
<a href="<?= route('setlocale', ['lang' => 'ru']) ?>">
    @if($item->hasLocaleName('ru'))<span class="glyphicon glyphicon-ok"></span>@endifРусский
</a>
<a href="<?= route('setlocale', ['lang' => 'ch']) ?>">
    @if($item->hasLocaleName('ch'))<span class="glyphicon glyphicon-ok"></span>@endif简体中文
</a>