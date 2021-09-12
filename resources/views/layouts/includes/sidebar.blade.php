<aside class="sidebar">
    <div class="sidebar__menu-group">
        <ul class="sidebar_nav">
            <li class="menu-title">
                <span>Main Menu</span>
            </li>
            <li>
                <a href="{{ route('barangays.index') }}" class="{{ request()->is('barangays') ? 'active' : null }}">
                    <span data-feather="home" class="nav-icon"></span>
                    <span class="menu-text">Barangays</span>
                </a>
                <a href="{{ route('facilities.index') }}" class="{{ request()->is('facilities') ? 'active' : null }}">
                    <span data-feather="heart" class="nav-icon"></span>
                    <span class="menu-text">Facilities</span>
                </a>
                <a href="{{ route('diseases.index') }}" class="{{ request()->is('diseases') ? 'active' : null }}">
                    <span data-feather="frown" class="nav-icon"></span>
                    <span class="menu-text">Diseases</span>
                </a>
                <a href="{{ route('scanners.index') }}" class="{{ request()->is('scanners') ? 'active' : null }}">
                    <span data-feather="camera" class="nav-icon"></span>
                    <span class="menu-text">Scanners</span>
                </a>
                <a href="{{ route('requests.index') }}" class="{{ request()->is('requests') ? 'active' : null }}">
                    <span data-feather="mail" class="nav-icon"></span>
                    <span class="menu-text">Requests</span>
                </a>
                <a href="{{ route('residents.index') }}" class="{{ request()->is('residents') ? 'active' : null }}">
                    <span data-feather="users" class="nav-icon"></span>
                    <span class="menu-text">Residents</span>
                </a>
                <a href="{{ route('valid-ids.index') }}" class="{{ request()->is('valid-ids') ? 'active' : null }}">
                    <span data-feather="credit-card" class="nav-icon"></span>
                    <span class="menu-text">Valid ID's</span>
                </a>
                <a href="{{ route('maps.index') }}" class="{{ request()->is('maps') ? 'active' : null }}">
                    <span data-feather="map" class="nav-icon"></span>
                    <span class="menu-text">Map</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
