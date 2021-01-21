
let Vote =
    {
        BaseUrl : "http://localhost:8000/",
        init : function()
        {
            let ButtonsVote = document.querySelectorAll('.Voter');

            for(let i=0;i<ButtonsVote.length;i+=1)
                ButtonsVote[i].addEventListener('click', Vote.voteInit);
        },
        voteInit : function(Ev)
        {
            let ParentElm = Ev.currentTarget.parentNode;
            let Candidat = ParentElm.firstElementChild.getAttribute('class').split(' ');
            let ButtonVote = ParentElm.querySelector('.Voter');

            Vote.voter(Candidat[1], ButtonVote, ParentElm);
        },
        voter : function(Candidat, ButtonVote, ParentElm)
        {
            let Url = Vote.BaseUrl+'vote/'+Candidat;
            let FetchOptions =
                {
                    method : 'GET',
                    mode : 'cors',
                    cache : 'no-cache'
                };

            fetch(Url, FetchOptions)
                .then(function(response)
                    {
                        if(response.status == 201)
                        return response.json();
                        if(response.status == 200) {
                            return response.json();
                        }
                    }
                )
                .then(function(response, status)
                {

                    if(response['Status'] == 201)
                    {
                        Vote.updateButton(ButtonVote, ParentElm, JSON.stringify(response));
                        Vote.updatePourcentBarre(response);
                    }
                    if(response['Status'] == 200)
                    {
                        window.location.href = response['RedirectURL'];
                    }



                })
                .catch(error => alert("Erreur : " + error))
            ;

        },
        updateButton: function(ButtonVote, ParentElm, Candidat)
        {
            let C = JSON.parse(Candidat);
            let CandidatCard = document.querySelector(".Card"+C['CandidatActuel']);
            let LastCandidatCard;

            ButtonVote.textContent = 'Votre vote - annuler';
            ButtonVote.className = 'Voter AnnulerVote';

            Vote.updateAllButtons(CandidatCard.className.split(' ') );
        },
        updateAllButtons: function(CandidatCardActuel)
        {
            let AllButons = document.querySelectorAll('.Voter');

            for(let i=0; i < AllButons.length; i+=1)
            {
                let ClassName = AllButons[i].parentElement.className.split(' ');
                if(ClassName[1] != CandidatCardActuel[1] )
                {
                    AllButons[i].textContent = 'Voter';
                    AllButons[i].className = 'Voter';
                }
            }
        },
        updatePourcentBarre: function(Response)
        {
            let BarrePourcent = document.querySelectorAll('.BarrePourcent');
            let PourcentTXT = document.querySelectorAll('.Pourcent');

            console.log(Response);
            for(let i=0; i < BarrePourcent.length; i+=1)
            {
                BarrePourcent[i].style.width = ( Response['NbVotesArray'][i] / Response['TotalVote'] ) * 100+'%';
                PourcentTXT[i].textContent = (( Response['NbVotesArray'][i] / Response['TotalVote'] ) * 100).toFixed(2)+'%';
            }
        }
    }

    Vote.init();