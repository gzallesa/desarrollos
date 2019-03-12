
var getLocalization = function () {
var localizationobj = {};
        localizationobj.pagergotopagestring = "Ir a página:";
        localizationobj.pagershowrowsstring = "Mostrar filas:";
        localizationobj.pagerrangestring = " de ";
        localizationobj.pagernextbuttonstring = "siguiente";
        localizationobj.pagerpreviousbuttonstring = "atras";
        localizationobj.sortascendingstring = "Orden Ascendente";
        localizationobj.sortdescendingstring = "Orden Descendente";
        localizationobj.sortremovestring = "Cancelar Orden";
        localizationobj.firstDay = 1;
        localizationobj.percentsymbol = " % ";
        localizationobj.currencysymbol = "Bs";
        localizationobj.currencysymbolposition = "after";
        localizationobj.decimalseparator = ", ";
        localizationobj.thousandsseparator = ".";
        
        var days = {
// full day names
        names: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
// abbreviated day names
                namesAbbr: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
// shortest day names
                namesShort: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"]
                };
        localizationobj.days = days;
        var months = {
// full month names (13 months for lunar calendards — 13th month should be "" if not lunar)
        names: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre",
                "Noviembre", "Diciembre", ""],
// abbreviated month names
                namesAbbr: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic", ""]
                };
        var patterns = {
        d: "dd/MM/yyyy",
                D: "dddd, d MMMM yyyy",
                t: "HH:mm",
                T: "HH:mm:ss",
                f: "dddd, d MMMM yyyy HH:mm",
                F: "dddd, d MMMM yyyy HH:mm:ss",
                M: "dd MMMM",
                Y: "MMMM yyyy"
                }
        localizationobj.patterns = patterns;
        localizationobj.months = months;
        localizationobj.todaystring = "Hoy";
        localizationobj.clearstring = "Cancelar";
        return localizationobj;
}

