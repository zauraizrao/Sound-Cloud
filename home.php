<?php
include('db_connect.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if it's not already active
}

// Check if login_id is set in $_SESSION
$login_id = isset($_SESSION['login_id']) ? $_SESSION['login_id'] : null;

// Query to get total genres
$genres_query = $conn->query("SELECT * FROM genres");
$total_genres = $genres_query ? $genres_query->num_rows : 0;

// Query to get total uploads
$uploads_query = $conn->query("SELECT * FROM uploads");
$total_uploads = $uploads_query ? $uploads_query->num_rows : 0;

// Query to get total playlist
$playlist_query = $conn->query("SELECT * FROM playlist");
$total_playlist = $playlist_query ? $playlist_query->num_rows : 0;

// Query to get total users
$users_query = $conn->query("SELECT * FROM users where type = 2");
$total_users = $users_query ? $users_query->num_rows : 0;

// Query to get total uploads by the logged-in user
$my_uploads_query = $conn->query("SELECT * FROM uploads where user_id = $login_id");
$my_uploads_count = $my_uploads_query ? $my_uploads_query->num_rows : 0;

// Query to get total playlist by the logged-in user
$my_playlist_query = $conn->query("SELECT * FROM playlist where user_id = $login_id");
$my_playlist_count = $my_playlist_query ? $my_playlist_query->num_rows : 0;
?>

<!-- Display Info boxes -->
<div class="row">
    <!-- Total Genres -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box bg-black border border-primary">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-th-list text-gradient-primary"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Genres</span>
                <span class="info-box-number"><?php echo $total_genres; ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <!-- Total Musics -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box bg-black border border-primary">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-music text-gradient-primary"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Musics</span>
                <span class="info-box-number"><?php echo $total_uploads; ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <!-- Total Playlist -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box bg-black border border-primary">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-list text-gradient-primary"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Playlist</span>
                <span class="info-box-number"><?php echo $total_playlist; ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <!-- Total Users -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box bg-black border border-primary">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users text-gradient-primary"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Users</span>
                <span class="info-box-number"><?php echo $total_users; ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <!-- My Musics -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box bg-black border border-primary">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-music text-gradient-primary"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">My Musics</span>
                <span class="info-box-number"><?php echo $my_uploads_count; ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <!-- My Playlist -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box bg-black border border-primary">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-list text-gradient-primary"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">My Playlist</span>
                <span class="info-box-number"><?php echo $my_playlist_count; ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
