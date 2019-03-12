/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function trailScroll()
{
    this.positions=new Array();
    this.idfs=new Array();
    this.existe=function(idf)
    {
        for(i=0;i<this.length();i++)
        {
            if(this.idfs[i]===idf)
            {
                return true;
            }
        }
        return false;
    }
    this.getPosition=function(idf)
    {
        var aux=new Array();
        var aux2=new Array();
        var sw=0;
        var i=0;
        var r;
        while(sw==0 && i<this.length())
        {
            if(this.idfs[i]==idf)
            {
                sw=1;
                r=this.positions[i];
                this.idfs=aux;
                this.positions=aux2;
                return r;
            }
            aux.push(this.idfs[i]);
            aux2.push(this.positions[i]);
            i++;
        }
        return 0;
    }
    this.addTrail=function(idf,position)
    {
        if(this.existe(idf))return;
        this.positions.push(position);
        this.idfs.push(idf);
        console.log(this.idfs);
        console.log(this.positions);
    }
    this.mostrar=function()
    {
        for(i=0;i<this.length();i++)
        {
            alert(this.idfs[i]+'-'+this.positions[i]);
        }
    }
    this.length=function()
    {
        return this.positions.length;
    }
}


