<div>
    Hello, {{ Auth::user()->username }}!
</div>

<form action="{{ route('user.logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-danger">Logout</button>
</form>
