@include('partials.header')

<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<header id="small-header">
    <div id="small-logo">
        <a href="{{ url('/') }}">Rate A Rescue</a>
    </div>
    <nav>
        <ul>
            <li class="dropdown menu-list-item">
                <a href="#" class="dropdown-toggle menu-item" data-toggle="dropdown" role="button" aria-expanded="false">Top <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url('top/cute') }}">Cute</a></li>
                    <li><a href="{{ url('top/tuff') }}">Tuff</a></li>
                    <li><a href="{{ url('top/tiny') }}">Tiny</a></li>
                    <li><a href="{{ url('top/happy') }}">Happy</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <form id="small-search" method="post" action="{{ url('/') }}/">
        <p class="form-text">FIND</p>

        <div class="radio">
            <div>
                <input id="option-dog" type="radio" name="animal" value="dog" checked="checked">
                <label for="option-dog"><span><span></span></span>Dogs</label>
            </div>
            <div>
                <input id="option-cat" type="radio" name="animal" value="cat">
                <label for="option-cat"><span><span></span></span>Cats</label>
            </div>
        </div>

        <div class="form-group">
            <input type="text" name="zipcode" placeholder="Zipcode" class="input-sm"/>
        </div>

        <input type="submit" value="Search" class="btn btn-success btn-xs" />
    </form>
</header>

<div id="breadcrumbs">
    @if(isset($query))
        <span id="current-num">1</span> of <span id="total-num">25</span> Dogs near {{ $query['zipcode'] }}
    @else
        Ranked <span id="current-num">1</span> of <span id="total-num">25</span> in {{ ucfirst($rating_slug) }}
    @endif

</div>

<section id="pet">
    <a id="prev-pet">
        <i class="fa fa-caret-left"></i>
    </a>
    <a id="next-pet">
        <i class="fa fa-caret-right"></i>
    </a>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-4 col-md-offset-3">
                <div class="main-crop">
                    <?php $photos = $pets[0]->getPhotos(); ?>
                    <img id="pet-img" src="{{ $photos[0] }}" />
                </div>
            </div>
            <div class="col-xs-12 col-md-5">
                <div id="pet-info">
                    <h1 id="pet-name">{{ $pets[0]->name }}</h1>
                    <p id="pet-details"><span id="pet-animal">{{ $pets[0]->animal }}</span> • <span id="pet-breed">{{ $pets[0]->breed }}</span></p>
                    <p id="pet-location"><span id="pet-zipcode">{{ $pets[0]->zipcode }}</span></p>
                    <p id="pet-availability">Available since <span id="pet-date">{{ $pets[0]->last_available }}</span> <span id="pet-checkavailability" class="fa fa-refresh"></span></p>
                    <p><a id="view-pet-finder" href="https://www.petfinder.com/petdetail/{{ $pets[0]->pet_id }}/">View <span class="pet-name">{{ $pets[0]->name }}</span> on Petfinder.com</a></p>
                    <div id="share-buttons">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row">

<div id="ratings-list">
    <a href="#" class="rating first vote btn" data-vote="cute">Cute</a>
    <a href="#" class="rating second vote btn" data-vote="tuff">Tuff</a>
    <a href="#" class="rating third vote btn" data-vote="tiny">Tiny</a>
    <a href="#" class="rating fourth vote btn" data-vote="happy">Happy</a>
</div>

    </div>
</div>

<div id="comment-wrapper">
    <section id="facebook-comments">
        <div class="fb-comments" data-test="asd" data-href="{{ url('pet/'.$pets[0]->pet_id) }}" data-width="600" data-numposts="5" data-colorscheme="light"></div>
    </section>
</div>

@include('partials.footer')

<script>
    var activeIndex = 0;
    var pets = {{ json_encode($pets) }};
    @if($votes)
    var votes = {{ json_encode($votes) }};
    @else
    var votes = [];
    @endif


    // Check Pet Availability
    $(function(){
        $('#pet-checkavailability').click(function(event){
            event.preventDefault();
            // Give User Feedback that request was sent
            $('#pet-checkavailability').addClass('fa-spin');
            checkAvailability();
        });

    });

    function checkAvailability(){
        var url = '{{ url('pet/getStatus') }}/' + pets[activeIndex].pet_id;
        $.ajax(url)
            .complete(function(data){
                if(data){
                    $('#pet-date').text(data.responseText);
                }
                else{
                    $('#pet-data').text('This pet seems to be unavailable. Please check the Petfinder link below.');
                }
                // Give User Feedback that response was received
                $('#pet-checkavailability').removeClass('fa-spin');
            });
    }

    // Create Votes for Pets
    $(function(){
        $('.vote').click(function(event){
            event.preventDefault();
            var slug = $(this).data('vote');
            sendVote(slug);
        });
    });

    function sendVote(slug){
        url = '{{ url('vote') }}/' + pets[activeIndex].pet_id + '/' + slug;
        $.ajax(url)
            .success(function(data){
                votes.push({pet_id: pets[activeIndex].pet_id, slug: slug});
                nextPet();
            });
    }

    // Disable Buttons Based on Votes Array
    $(function(){
        disableByVotes();
    });

    function disableByVotes(){
        $('.vote').removeAttr('disabled', 'disabled');
        for(var i = 0; i < votes.length; i++){
            if(votes[i].pet_id == pets[activeIndex].pet_id){
                disableButton($('[data-vote="'+votes[i].slug+'"]'));
            }
        }
    }

    function disableButton(btn){
        btn.attr('disabled', 'disabled');
    }

    // Change Pet Data
    $(function(){
        $('#prev-pet').click(function(){
           prevPet();
        });
        $('#next-pet').click(function(){
            nextPet();
        });
    });

    function prevPet(){
        if(activeIndex > 0){
            activeIndex--;
            updatePet();
            disableByVotes();
        }
    }

    function nextPet(){
        if(activeIndex < pets.length){
            activeIndex++;
            updatePet();
            disableByVotes();

            if(activeIndex == pets.length - 2){
                loadPets();
            }
        }
    }

    function updatePet(){
        $('#pet-name').text(pets[activeIndex].name);
        $('.pet-name').text(pets[activeIndex].name);
        $('#pet-animal').text(pets[activeIndex].animal);
        $('#pet-breed').text(pets[activeIndex].breed);
        photos = pets[activeIndex].photos.split('|p|');
        $('#pet-img').attr('src', photos[0]);
        $('#pet-date').text(pets[activeIndex].last_available);
        $('#view-pet-finder').attr('href', 'https://www.petfinder.com/petdetail/'+pets[activeIndex].pet_id);

        $('#current-num').text(activeIndex + 1);
        $('#total-num').text(pets.length);

        // Replace http://site.com/pet/<PET_ID> or http://site.com/top/<PET_ID> with new pet_id
        var url = window.location.href;

        var to = url.lastIndexOf('/');
        to = to == -1 ? url.length : to + 1;
        url = url.substring(0, to);

        resetComments(url + pets[activeIndex].pet_id);

        history.replaceState(null, null, url + pets[activeIndex].pet_id);
    }

    function resetComments(url){
        var html = '<section id="facebook-comments"><div class="fb-comments" data-test="asd" data-href="' + url + '" data-width="600" data-numposts="5" data-colorscheme="light"></div></section>';
        $('#comment-wrapper').html('');
        $('#comment-wrapper').html(html);

        FB.XFBML.parse();
    }

    // Load More Pets

    function loadPets(){
        // If Zipcode has been set, we load pets from near zipcode
        @if(isset($query))
        var url = '{{ url('/pet/get/'.$query['zipcode'].'/'.$query['animal']) }}/' + pets.length;
        $.getJSON(url, function(data){
            pets = pets.concat(data);
        });
        @else
        var url = window.location.href + '/' + pets.length;
        $.getJSON(url, function(data){
            pets = pets.concat(data);
        });
        @endif

    }

    // Load Page Variables on load
    $(function(){
        updatePet();
    });
</script>
