@include('partials.header')

<div class="row">
    <div class="col-xs-12 text-center">
        <div id="pet">
            <div class="left-arrow">
                <a id="prev-pet" href="#"><i class="fa  fa-arrow-circle-left"></i></a>
            </div>
            <?php $photos = $pets[0]->getPhotos(); ?>
            <img id="pet-img" src="{{ $photos[0] }}" class="img-responsive"/>
            <div class="right-arrow">
                <a id="next-pet" href="#"><i class="fa  fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>
    <div id="pet-actions">
        <div class="col-xs-12 col-sm-4">
            <p>
                <a href="#" data-vote="{{ $ratings[0]->rating_slug }}" class="btn btn-primary btn-block vote">{{ $ratings[0]->rating_text }}</a>
            </p>
        </div>
        <div class="col-xs-12 col-sm-4">
            <p>
                <a href="#" data-vote="{{ $ratings[1]->rating_slug }}" class="btn btn-warning btn-block vote">{{ $ratings[1]->rating_text }}</a>
            </p>
        </div>
        <div class="col-xs-12 col-sm-4">
            <p>
                <a href="#" data-vote="{{ $ratings[2]->rating_slug }}" class="btn btn-success btn-block vote">{{ $ratings[2]->rating_text }}</a>
            </p>
        </div>
    </div>
    <div id="pet-info" class="col-xs-12 text-center">
        <div class="well">
            <h1 class="pet-name">{{ $pets[0]->name }}</h1>
            <p><span class="pet-name">{{ $pets[0]->name }}</span> was still needing a home as of <span id="pet-date">{{ $pets[0]->last_available }}</span>. <a id="check-availability" href="#">Check availability</a></p>
            <h4><a id="pet-link" href="https://www.petfinder.com/petdetail/{{ $pets[0]->pet_id }}">Get more information for <span class="pet-name">{{ $pets[0]->name }}</span> on PetFinder.</a></h4>
        </div>
    </div>
</div>

@include('partials.footer')

<script>
    var pets = {{ json_encode($pets) }};

    @if($votes)
        var votes = {{ json_encode($votes) }};
    @else
        var votes = new Array();
    @endif
    var activeIndex = 0;
    var querySent = false;

    $(function(){
        $("#next-pet").click(function(event){
            event.preventDefault();

            nextPet();
        });

        $("#prev-pet").click(function(event){
            event.preventDefault();

            prevPet();
        });

        $(".vote").click(function(event){
            event.preventDefault();

            var vote = $(this).data('vote');
            sendVote(vote);
        });

        $('#check-availability').click(function(event){
            event.preventDefault();

            checkAvailability();
        });

        updatePage();
    });

    function checkAvailability(){
        url = "{{ url('pet/getStatus') }}/" + pets[activeIndex].pet_id;

        $.ajax(url)
                .done(function(data){
                    if(data){
                        pets[activeIndex].last_available = 'today';
                        $('#pet-date').text(pets[activeIndex].last_available);
                        $('#pet-date + a').hide();
                    }
                });
    }

    function showPet(pet){
        $('#pet-img').attr('src', getPhoto(pet.photos));
        $('.pet-name').text(pet.name);
        $('#pet-description').text(pet.description);
        $('#pet-link').attr("href", "https://www.petfinder.com/petdetail/"+pets[activeIndex].pet_id);
        $('#pet-date').text(pets[activeIndex].last_available);
        if(pets[activeIndex].last_available == 'today'){
            $('#pet-date + a').hide();
        }
        else{
            $('#pet-date + a').show();
        }
    }

    function updatePage(){
        history.replaceState(activeIndex, null, pets[activeIndex].pet_id);
        showPet(pets[activeIndex]);
        resetVotedOn();
        disableVotedOn();

        console.log(pets);
    }

    function updatePosition(){
        $('#activeIndex').text(activeIndex + 1);
    }

    function updateTotal(){
        $('#totalIndex').text(pets.length);
    }

    function getPhoto(photos){
        photo = photos.split("|p|");
        return photo[0];
    }

    function getPets(){
        querySent = true;
        url = "{{ url('top/'.$rating_slug.'/offset/') }}/" + pets.length;
        $.getJSON( url )
                .done(function(data) {
                    pets = pets.concat(data);
                    updateTotal();
                    querySent = false;
                });
    }

    function nextPet(){
        if(activeIndex + 1 < pets.length){
            activeIndex++;
            updatePage();

            if(activeIndex + 1 == pets.length && !querySent){
                getPets();
            }
        }
    }

    function prevPet(){
        if(activeIndex > 0){
            activeIndex--;
            updatePage();
        }
    }

    function sendVote(slug){
        var url = "{{ url('/vote') }}/"+pets[activeIndex].pet_id + "/" + slug;
        disableVoteButton(slug);
        $.ajax(url)
                .done(function(data){
                    if(data){
                        votes.push({
                            pet_id:  pets[activeIndex].pet_id,
                            slug: slug
                        });
                    }
                });
    }

    function disableVoteButton(slug){
        $('.btn[data-vote="'+slug+'"]').attr('disabled', 'disabled');
    }

    function resetVotedOn(){
        $('.btn[data-vote="{{ $ratings[0]->rating_slug }}"]').removeAttr('disabled');
        $('.btn[data-vote="{{ $ratings[1]->rating_slug }}"]').removeAttr('disabled');
        $('.btn[data-vote="{{ $ratings[2]->rating_slug }}"]').removeAttr('disabled');
    }

    function disableVotedOn(){
        for(var i = 0; i < votes.length; i++){
            if(votes[i].pet_id == pets[activeIndex].pet_id){
                disableVoteButton(votes[i].slug);
            }
        }
    }
</script>