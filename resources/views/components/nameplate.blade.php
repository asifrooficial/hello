@auth
<h2>       
    <form action="#" class="ml-2 d-inline" method="POST">       
        <a href="/manage-avatar"><img title="Upload Avatar" style="width: 84px; height: 84px; border-radius: 42px" src="{{ auth()->user()->avatar }}" /></a> {{ auth()->user()->username }}
    </form>
</h2>
@endauth  

