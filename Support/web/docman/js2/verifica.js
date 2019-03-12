/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function isValid(f)
{
    nr=0;
    for(i=0;i<11;i++)
    {
        if(i<=3)
        {
            if(f.elements[i].style.color=='red' || f.elements[i].value=='')
            {
                nr++;
            }
        }else
        {
            if(f.elements[i].style.color=='red' && f.elements[i].value!='')
            {
                nr++;
            }
        }
    }    
    if(nr>0)
    {
            return false;
    }
    return true;
}
function verifica(field,tipo)
{
    var cad=/^[a-zA-Z][a-zA-Z\ \ñ\Ñ]+[a-zA-Z]$/;
    var pass=/^[a-zA-Z0-9]{6,30}$/;
    var telef=/^[0-9]{5,10}$/;
    var cel=/^[0-9]{5,12}$/;
    var esp=/^[a-zA-Z0-9][a-zA-Z0-9\ \-\_]+[a-zA-Z0-9]$/;
    var num=/^[0-9]{5,10}$/;
    var email=/^[a-zA-Z0-9]+[\-\_\.a-zA-Z0-9]+\@[a-z]+(\.[a-z]{2,3}){1,2}$/;
        switch(tipo){
            case 0:
                if(!cad.test(field.value))
                {
                    field.style.color='red';
                }else
                {
                    field.style.color='black';
                }
                break;
            case 1:
                if(!esp.test(field.value))
                {
                    field.style.color='red';
                }else
                {
                    field.style.color='black';
                }
                break;
            case 2:
                if(!email.test(field.value))
                {
                    field.style.color='red';
                }else
                {
                    field.style.color='black';
                }
                break;
            case 3:
                if(!num.test(field.value))
                {
                    field.style.color='red';
                }else
                {
                    field.style.color='black';
                }
                break;
            case 4:
                if(!pass.test(field.value))
                {
                    field.style.color='red';
                }else
                {
                    field.style.color='black';
                }
                break;
            case 5:
                if(!telef.test(field.value))
                {
                    field.style.color='red';
                }else
                {
                    field.style.color='black';
                }
                break;
            case 6:
                if(!cel.test(field.value))
                {
                    field.style.color='red';
                }else
                {
                    field.style.color='black';
                }
                break;
        }
}
function verifica2(field1,field2)
{
    if(field2.value!=field1.value)
    {
        field1.style.color='red';
    }else
    {
        field1.style.color='black';
        field2.style.color='black';
    }
}



