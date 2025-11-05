<style>
.topbar {
    width: 100%;
    height: 60px;
    background-color: white;
    border-bottom: 1px solid black;
    position: absolute;
    top: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile {
    color: black;
    cursor: pointer;
    position: relative;
}

.profile_hidden {
    width: max-content;
    padding: 10px;
    background-color: white;
    border: 1px solid #ccc;
    position: absolute;
    right: 0;
    top: 50px;
    display: none;
    z-index: 10;
}

.profile_hidden ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.profile_hidden ul li {
    padding: 10px 15px;
}

.profile_hidden ul li a {
    text-decoration: none;
    color: black;
    font-weight: 600;
}

.profile_hidden ul li:hover {
    background-color: #f0f0f0;
}
</style>

<div class="topbar row  px-3">
    <div class="col-5 col-md-2">
        <img src="{{ asset($setting->logo ?? 'assets/image/companies/logo.png') }}" alt="Logo" width="200px" height="50px">
    </div>
    <div class="col-md-7"></div>
    <div class="col-md-3">
        <div id="profile" class="profile">
            {{ Auth()->user()->name }}
        </div>
        <div id="profile_hidden" class="profile_hidden">
            <ul>
                <li><a href="#">Profile</a></li>
                <li><a href="#">Change Password</a></li>
               <li>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" style="background: none; border: none; padding: 0; color: black; font-weight: 600; cursor: pointer;">
            Logout
        </button>
    </form>
</li>
            </ul>
        </div>
    </div>
</div>

<script>
    const profile = document.getElementById('profile');
    const profile_hidden = document.getElementById('profile_hidden');

    profile.addEventListener('click', () => {
        // Toggle visibility
        if (profile_hidden.style.display === 'block') {
            profile_hidden.style.display = 'none';
        } else {
            profile_hidden.style.display = 'block';
        }
    });

    // Optional: hide the menu when clicking outside
    document.addEventListener('click', (event) => {
        if (!profile.contains(event.target) && !profile_hidden.contains(event.target)) {
            profile_hidden.style.display = 'none';
        }
    });
</script>
