<!DOCTYPE html>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

*{
  font-family: "Poppins";
}
  #search-modal .modal-content {
    border-radius: 10px;
    overflow: hidden;
  }
  #search-modal .modal-header {
    background-color: #333;
    color: #fff;
  }
  #search-modal .modal-body {
    padding: 20px;
  }
  #search-modal .modal-footer {
    background-color: #f8f9fa;
  }
  #search-results .result-item {
    color: black;
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
    cursor: pointer;
  }
  #search-results .result-item:hover {
    background-color: #f0f0f0;
  }
</style>

<html lang="en">
<?php session_start() ?>
<?php 
	if(!isset($_SESSION['login_id']))
	    header('location:login.php');


	include 'header.php' 
?>

<script>
  $(document).ready(function() {
    // Open the search modal
    $('#search-button').on('click', function() {
      $('#search-modal').modal('show');
    });

    // Handle search query
    $('#search-query').on('input', function() {
      const query = $(this).val();
      if (query.length >= 3) {
        searchSpotify(query);
      }
    });

    function searchSpotify(query) {
      const accessToken = 'BQADQ77mcf_84IDRo7tkopa27WJ2kF72Y6EGrN7g-rCDFy19AvGeR5yBOnW2tX9BOnhWRwn2xxX04V4fydOxZD_4_Cz0h3RhV-TnuNGVhKckdFT2dVg'; // Replace with your Spotify access token
      $.ajax({
        url: `https://api.spotify.com/v1/search?q=${encodeURIComponent(query)}&type=track&limit=10`,
        headers: {
          'Authorization': `Bearer ${accessToken}`
        },
        success: function(data) {
          displaySearchResults(data.tracks.items);
        },
        error: function() {
          alert('Error fetching data from Spotify.');
        }
      });
    }

    function displaySearchResults(tracks) {
      const resultsContainer = $('#search-results');
      resultsContainer.empty();
      tracks.forEach(track => {
        const resultItem = `
          <div class="result-item" data-src="${track.preview_url}" data-id="${track.id}">
            <strong>${track.name}</strong> by ${track.artists.map(artist => artist.name).join(', ')}
          </div>
        `;
        resultsContainer.append(resultItem);
      });

      // Handle click on search result
      $('.result-item').on('click', function() {
        const src = $(this).data('src');
        const id = $(this).data('id');
        playMusic(src, id);
        $('#search-modal').modal('hide');
      });
    }

    function playMusic(src, id) {
      var audio = $('<audio controls class="bg-black" id="mplayer" data-id="'+id+'"></audio>');
      if (src) {
        audio.append('<source src="'+src+'">');
        var player=  $('#audio-player');
        player.find('audio').remove();
        player.append(audio);
        document.getElementById('mplayer').play();
        $('.p-player').attr('data-type','pause');
        $('.p-player').html('<i class="fa fa-pause"></i>');
      }
    }
  });
</script>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <?php include 'topbar.php' ?>
  <?php include 'sidebar.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper  bg-dark">
  	 <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
	    <div class="toast-body text-white">
	    </div>
	  </div>
    <div id="toastsContainerTopRight" class="toasts-top-right fixed"></div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
     
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <?php $page = isset($_GET['page']) ? $_GET['page']:'home' ?>
      <div class="container-fluid text-dark viewer-panel" style="margin-bottom: 4rem">
         <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <?php
            $title = isset($_GET['page']) ? ucwords(str_replace("_", ' ', $_GET['page'])) : "Home";
             ?>
            <h1 class="m-0 text-gradient-primary"><?php echo $title ?></h1>
          </div><!-- /.col -->

        </div><!-- /.row -->
            <hr class="border-primary">
      </div><!-- /.container-fluid -->
         <?php 
            if(!file_exists($page.".php")){
                include '404.html';
            }else{
            include $page.'.php';

            }
          ?>
          
        
      </div><!--/. container-fluid -->
      <style>
   .text-gradient-primary {
  background: linear-gradient(to right, #003366, #3399ff, #ffffff); /* Dark blue to blue to white gradient */
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}



        
            audio::-webkit-media-controls {
                width: inherit;
                height: inherit;
                position: relative;
                direction: ltr;
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                align-items: center;
                background: white;
            }
            audio::-webkit-media-controls-enclosure, video::-webkit-media-controls-enclosure {
                width: 100%;
                max-width: 800px;
                height: 30px;
                background: none;
                flex-shrink: 0;
                bottom: 0;
                text-indent: 0;
                padding: 0;
                box-sizing: border-box;
            }
            audio::-webkit-media-controls-play-button{
                display: none;
               
            }
            .audio-control-btn:hover{
              color:white
            }
               
          </style>
      <div id="audio-player" class="d-flex w-100 justify-content-end align-items-center bg-dark py-1 position-absoulute">
        
            <button class="btn prev-player audio-control-btn" onclick="_prev($(this))" data-type="play"><i class="fa fa-step-backward"></i></button>
            <button class="btn p-player audio-control-btn" onclick="_player($(this))" data-queue="0" data-type="play" style="font-size: 25px"><i class="fa fa-play"></i></button>
            <button class="btn next-player audio-control-btn" onclick="_next(-1,1)" data-type="play"><i class="fa fa-step-forward"></i></button>
            <audio controls class="bg-black" ended="nextAudioNode.play();" id="mplayer">
              
            </audio>
        </div>
    </section>
    <script>
      function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
      }
      var src_arr = {};
      $(document).ready(function(){
        if(getCookie('src') != ''){
          var parsed = JSON.parse(getCookie('src'))
          var q = getCookie('pq') != '' ? getCookie('pq') : '';
          play_music(parsed,q,0)
        }
      })
      function _player(_this){
        var type = _this.attr('data-type')
        if($('#mplayer source').length <= 0)
          return false;
        if(type == 'play'){
          _this.attr('data-type','pause')
          _this.html('<i class="fa fa-pause"></i>')
          document.getElementById('mplayer').play()
        }else{
          _this.attr('data-type','play')
           _this.html('<i class="fa fa-play"></i>')
          document.getElementById('mplayer').pause()
        }
      }

      function play_music($src,$i=0,$p = 1){
      var audio = $('<audio controls class="bg-black" id="mplayer" data-queue = "'+$i+'"></audio>')
          if(typeof $src === 'object'){
             src_arr = $src;
           $src = $src[$i].upath
         }

         document.cookie = "src="+JSON.stringify(src_arr)
         document.cookie = "pq="+$i
          var csrc = $('#mplayer source').attr("src")
          if( $src != csrc){
             audio.append('<source src="'+$src+'">')
             var player=  $('#audio-player')
             player.find('audio').remove()
             player.append(audio)
             get_details(src_arr[$i].id)
           }else{
             if(!document.getElementById('mplayer').paused == true){
               document.getElementById('mplayer').pause()
               return false;
             }
           }
        
       
         // curA.remove()
         if($p == 1){
          document.getElementById('mplayer').play()
           $('.p-player').attr('data-type','pause')
          $('.p-player').html('<i class="fa fa-pause"></i>')
         }
          m_end()
      }
      function _prev($i=-1){
          $i=parseInt($('#mplayer').attr('data-queue'))-1;
        if(!!src_arr[$i]){
           var audio = $('<audio controls class="bg-black" id="mplayer" data-queue = "'+$i+'"></audio>')
         document.cookie = "pq="+$i

        audio.append('<source src="'+src_arr[$i].upath+'">')
             var player=  $('#audio-player')
             player.find('audio').remove()
             player.append(audio)
             get_details(src_arr[$i].id)
            document.getElementById('mplayer').play()
           $('.p-player').attr('data-type','pause')
          $('.p-player').html('<i class="fa fa-pause"></i>')
           m_end()
        }
      }
      function _next($i=-1,$p=0){
        if($i == -1)
        { 
          $i=parseInt($('#mplayer').attr('data-queue'))+1
        }
        if(!!src_arr[$i] && !!src_arr[$i].upath){
         document.cookie = "pq="+$i
           var audio = $('<audio controls class="bg-black" id="mplayer" data-queue = "'+$i+'"></audio>')
        audio.append('<source src="'+src_arr[$i].upath+'">')
             var player=  $('#audio-player')
             player.find('audio').remove()
             player.append(audio)
             get_details(src_arr[$i].id)
            document.getElementById('mplayer').play()
           $('.p-player').attr('data-type','pause')
          $('.p-player').html('<i class="fa fa-pause"></i>')
           m_end()
        }else{
           play_music(src_arr,0,$p)
        }
      }
      function m_end(){
        document.getElementById('mplayer').addEventListener('ended',function(){
           $('.p-player').attr('data-type','play')
            $('.p-player').html('<i class="fa fa-play"></i>')
            document.getElementById('mplayer').duration = 0
            _next(parseInt($('#mplayer').attr('data-queue'))+1)
        })
      }
      window.addEventListener('popstate', function(e){
         var nl = new URLSearchParams(window.location.search);
            var page =nl.get('page')
        $.ajax({
          url:"controller.php"+window.location.search,
          success:function(resp){
           $('.viewer-panel').html(resp)
          }
        })
      });
      function get_details($id){
        $.ajax({
          url:"ajax.php?action=get_details",
          method:'POST',
          data:{id:$id},
          success:function(resp){
            if(resp){
              resp = JSON.parse(resp)
              var _html = '<div id="pdet" class="d-flex justify-content-center align-items-center"><img src="assets/uploads/'+resp.cover_image+'" alt="" class="img-thumbnail bg-gradient-1" style="width: 50px;height: 50px;object-fit: cover"><div class="ml-2 mr-4"><div><b><large>'+resp.title+'</large></b></div><div><b><small>'+resp.artist+'</small></b></div></div></div>'
              if($('#audio-player #pdet').length > 0)
                $('#audio-player #pdet').remove()
              $('#audio-player').prepend(_html)
            }
          }
        })
      }
      _anchor()
      function _anchor(){
      $('a').click(function(e){
        e.preventDefault()
        var _h=  $(this).attr("href");
        if(document.href == _h){
          return false
        }
        window.history.pushState({}, null, $(this).attr("href"));
        var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
          var nl = new URLSearchParams(window.location.search);
          var page =nl.get('page')
          $('.nav-link').removeClass('active')
          if($('.nav-link.nav-'+page).length > 0){
            $('.nav-link.nav-'+page).addClass('active')
            if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
              $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
              $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
            }
            if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
              $('.nav-link.nav-'+page).parent().addClass('menu-open')
            }

          }
        $.ajax({
          url:"controller.php"+window.location.search,
          success:function(resp){
           $('.viewer-panel').html(resp)
           _anchor()
          }
        })
      })
      }
      function _redirect($url){
          window.history.pushState({}, null, $url);
          var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
            var nl = new URLSearchParams(window.location.search);
            var page =nl.get('page')
            $('.nav-link').removeClass('active')
            if($('.nav-link.nav-'+page).length > 0){
              $('.nav-link.nav-'+page).addClass('active')
              if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
                $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
                $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
              }
              if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
                $('.nav-link.nav-'+page).parent().addClass('menu-open')
              }

            }
          $.ajax({
            url:"controller.php"+window.location.search,
            success:function(resp){
             $('.viewer-panel').html(resp)
             _anchor()
            }
          })
      }
    </script>
    <!-- /.content -->
     <!-- Search Modal -->
<div class="modal fade" id="search-modal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="searchModalLabel">Search for Songs</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" id="search-query" class="form-control" placeholder="Search for songs...">
        <div id="search-results" class="mt-3"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

    <div class="text-dark">
    <div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-right"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div>
  </div>
  <!-- /.content-wrapper -->
</div>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer bg-black">
    <strong>Copyright &copy; 2024 <a href="#">Sound</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Sound</b>
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<!-- Bootstrap -->
<?php include 'footer.php' ?>
</body>
</html>
