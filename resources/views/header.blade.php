<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
  
<div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item {{ $route == 'home' ? 'active' : '' }}">
        <a class="nav-link" href="/">Home </a>
      </li>
      @if( !auth()->check() )
      <li class="nav-item {{ $route == 'login' ? 'active' : '' }}">
        <a class="nav-link" href="/login">Login</a>
      </li>
      <li class="nav-item {{ $route == 'register' ? 'active' : '' }}">
        <a class="nav-link" href="/register">Register</a>
      </li>
      @else
      <li class="nav-item {{ $route == 'posts' ? 'active' : '' }}">
        <a class="nav-link" href="/posts">Posts</a>
      </li>
      @endif
    </ul>
    <ul class="navbar-nav ml-auto" style="margin-right: 5%;">
        @if( auth()->check() )
        <!-- <li class="nav-item">
        <a class="nav-link" href="#">Logout</a>
        </li> -->
        <li class="nav-item dropdown" >
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ auth()->user()->fullname }}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="/accaunt/blogs">My Blogs</a>
            <a class="dropdown-item" href="/accaunt/settings">Settings</a>
            <a class="dropdown-item" href="/auth/logout">Logout</a>
            </div>
        </li>
        @endif
    </ul>
     
    
  </div>

</nav>