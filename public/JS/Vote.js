
let Vote =
    {
        init : function()
        {
            let ButtonsVote = document.querySelectorAll('.Voter');

            for(let i=0;i<ButtonsVote.length;i+=1)
                ButtonsVote[i].addEventListener('click', voteInit.voter);
        },
        voteInit : function(Ev)
        {
            let ParentElm = Ev.currentTarget.parentNode;
            let Candidat = ParentElm.firstElementChild.getAttribute('class').split(' ');


            console.log(Candidat);
        },
        Vote : function(Candidat)
        {

        }
    }



    Vote.init();