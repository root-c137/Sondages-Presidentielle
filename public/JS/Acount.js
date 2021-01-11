
let Account =
{
    UpdateInfosElm : document.querySelector('.UpdateInfos'),
    InfosElm : document.querySelector('.Infos'),
    AccountModeButton : document.querySelector('.AccountMode'),
    init : function()
    {
        Account.updateMode();
        Account.AccountModeButton.addEventListener('click', Account.updateMode);
    },
    updateMode : function ()
    {
        if(Account.UpdateInfosElm.style.display == 'none')
        {
            Account.UpdateInfosElm.style.display = 'flex';
            Account.InfosElm.style.display = 'none';

            Account.AccountModeButton.textContent = 'Afficher vos informations'
        }
        else if(Account.UpdateInfosElm.style.display != 'none')
        {
            Account.UpdateInfosElm.style.display = 'none';
            Account.InfosElm.style.display = 'flex';

            Account.AccountModeButton.textContent = 'Modifier vos informations'

        }

    }
}


Account.init();
