(function($){'use strict';$(function(){!function(a){"use strict";if("function"==typeof define&&define.amd)define(["jquery","moment"],a);else if("object"==typeof exports)module.exports=a(require("jquery"),require("moment"));else{if("undefined"==typeof jQuery)throw"bootstrap-datetimepicker requires jQuery to be loaded first";if("undefined"==typeof moment)throw"bootstrap-datetimepicker requires Moment.js to be loaded first";a(jQuery,moment)}}(function(a,b){"use strict";if(!b)throw new Error("bootstrap-datetimepicker requires Moment.js to be loaded first");var c=function(c,d){var e,f,g,h,i,j,k,l={},m=!0,n=!1,o=!1,p=0,q=[{clsName:"days",navFnc:"M",navStep:1},{clsName:"months",navFnc:"y",navStep:1},{clsName:"years",navFnc:"y",navStep:10},{clsName:"decades",navFnc:"y",navStep:100}],r=["days","months","years","decades"],s=["top","bottom","auto"],t=["left","right","auto"],u=["default","top","bottom"],v={up:38,38:"up",down:40,40:"down",left:37,37:"left",right:39,39:"right",tab:9,9:"tab",escape:27,27:"escape",enter:13,13:"enter",pageUp:33,33:"pageUp",pageDown:34,34:"pageDown",shift:16,16:"shift",control:17,17:"control",space:32,32:"space",t:84,84:"t",delete:46,46:"delete"},w={},x=function(){return void 0!==b.tz&&void 0!==d.timeZone&&null!==d.timeZone&&""!==d.timeZone},y=function(a){var c;return c=void 0===a||null===a?b():b.isDate(a)||b.isMoment(a)?b(a):x()?b.tz(a,j,d.useStrict,d.timeZone):b(a,j,d.useStrict),x()&&c.tz(d.timeZone),c},z=function(a){if("string"!=typeof a||a.length>1)throw new TypeError("isEnabled expects a single character string parameter");switch(a){case"y":return i.indexOf("Y")!==-1;case"M":return i.indexOf("M")!==-1;case"d":return i.toLowerCase().indexOf("d")!==-1;case"h":case"H":return i.toLowerCase().indexOf("h")!==-1;case"m":return i.indexOf("m")!==-1;case"s":return i.indexOf("s")!==-1;default:return!1}},A=function(){return z("h")||z("m")||z("s")},B=function(){return z("y")||z("M")||z("d")},C=function(){var b=a("<thead>").append(a("<tr>").append(a("<th>").addClass("prev").attr("data-action","previous").append(a("<span>").addClass(d.icons.previous))).append(a("<th>").addClass("picker-switch").attr("data-action","pickerSwitch").attr("colspan",d.calendarWeeks?"6":"5")).append(a("<th>").addClass("next").attr("data-action","next").append(a("<span>").addClass(d.icons.next)))),c=a("<tbody>").append(a("<tr>").append(a("<td>").attr("colspan",d.calendarWeeks?"8":"7")));return[a("<div>").addClass("datepicker-days").append(a("<table>").addClass("table-condensed").append(b).append(a("<tbody>"))),a("<div>").addClass("datepicker-months").append(a("<table>").addClass("table-condensed").append(b.clone()).append(c.clone())),a("<div>").addClass("datepicker-years").append(a("<table>").addClass("table-condensed").append(b.clone()).append(c.clone())),a("<div>").addClass("datepicker-decades").append(a("<table>").addClass("table-condensed").append(b.clone()).append(c.clone()))]},D=function(){var b=a("<tr>"),c=a("<tr>"),e=a("<tr>");return z("h")&&(b.append(a("<td>").append(a("<a>").attr({href:"#",tabindex:"-1",title:d.tooltips.incrementHour}).addClass("btn").attr("data-action","incrementHours").append(a("<span>").addClass(d.icons.up)))),c.append(a("<td>").append(a("<span>").addClass("timepicker-hour").attr({"data-time-component":"hours",title:d.tooltips.pickHour}).attr("data-action","showHours"))),e.append(a("<td>").append(a("<a>").attr({href:"#",tabindex:"-1",title:d.tooltips.decrementHour}).addClass("btn").attr("data-action","decrementHours").append(a("<span>").addClass(d.icons.down))))),z("m")&&(z("h")&&(b.append(a("<td>").addClass("separator")),c.append(a("<td>").addClass("separator").html(":")),e.append(a("<td>").addClass("separator"))),b.append(a("<td>").append(a("<a>").attr({href:"#",tabindex:"-1",title:d.tooltips.incrementMinute}).addClass("btn").attr("data-action","incrementMinutes").append(a("<span>").addClass(d.icons.up)))),c.append(a("<td>").append(a("<span>").addClass("timepicker-minute").attr({"data-time-component":"minutes",title:d.tooltips.pickMinute}).attr("data-action","showMinutes"))),e.append(a("<td>").append(a("<a>").attr({href:"#",tabindex:"-1",title:d.tooltips.decrementMinute}).addClass("btn").attr("data-action","decrementMinutes").append(a("<span>").addClass(d.icons.down))))),z("s")&&(z("m")&&(b.append(a("<td>").addClass("separator")),c.append(a("<td>").addClass("separator").html(":")),e.append(a("<td>").addClass("separator"))),b.append(a("<td>").append(a("<a>").attr({href:"#",tabindex:"-1",title:d.tooltips.incrementSecond}).addClass("btn").attr("data-action","incrementSeconds").append(a("<span>").addClass(d.icons.up)))),c.append(a("<td>").append(a("<span>").addClass("timepicker-second").attr({"data-time-component":"seconds",title:d.tooltips.pickSecond}).attr("data-action","showSeconds"))),e.append(a("<td>").append(a("<a>").attr({href:"#",tabindex:"-1",title:d.tooltips.decrementSecond}).addClass("btn").attr("data-action","decrementSeconds").append(a("<span>").addClass(d.icons.down))))),h||(b.append(a("<td>").addClass("separator")),c.append(a("<td>").append(a("<button>").addClass("btn btn-primary").attr({"data-action":"togglePeriod",tabindex:"-1",title:d.tooltips.togglePeriod}))),e.append(a("<td>").addClass("separator"))),a("<div>").addClass("timepicker-picker").append(a("<table>").addClass("table-condensed").append([b,c,e]))},E=function(){var b=a("<div>").addClass("timepicker-hours").append(a("<table>").addClass("table-condensed")),c=a("<div>").addClass("timepicker-minutes").append(a("<table>").addClass("table-condensed")),d=a("<div>").addClass("timepicker-seconds").append(a("<table>").addClass("table-condensed")),e=[D()];return z("h")&&e.push(b),z("m")&&e.push(c),z("s")&&e.push(d),e},F=function(){var b=[];return d.showTodayButton&&b.push(a("<td>").append(a("<a>").attr({"data-action":"today",title:d.tooltips.today}).append(a("<span>").addClass(d.icons.today)))),!d.sideBySide&&B()&&A()&&b.push(a("<td>").append(a("<a>").attr({"data-action":"togglePicker",title:d.tooltips.selectTime}).append(a("<span>").addClass(d.icons.time)))),d.showClear&&b.push(a("<td>").append(a("<a>").attr({"data-action":"clear",title:d.tooltips.clear}).append(a("<span>").addClass(d.icons.clear)))),d.showClose&&b.push(a("<td>").append(a("<a>").attr({"data-action":"close",title:d.tooltips.close}).append(a("<span>").addClass(d.icons.close)))),a("<table>").addClass("table-condensed").append(a("<tbody>").append(a("<tr>").append(b)))},G=function(){var b=a("<div>").addClass("bootstrap-datetimepicker-widget dropdown-menu"),c=a("<div>").addClass("datepicker").append(C()),e=a("<div>").addClass("timepicker").append(E()),f=a("<ul>").addClass("list-unstyled"),g=a("<li>").addClass("picker-switch"+(d.collapse?" accordion-toggle":"")).append(F());return d.inline&&b.removeClass("dropdown-menu"),h&&b.addClass("usetwentyfour"),z("s")&&!h&&b.addClass("wider"),d.sideBySide&&B()&&A()?(b.addClass("timepicker-sbs"),"top"===d.toolbarPlacement&&b.append(g),b.append(a("<div>").addClass("row").append(c.addClass("col-md-6")).append(e.addClass("col-md-6"))),"bottom"===d.toolbarPlacement&&b.append(g),b):("top"===d.toolbarPlacement&&f.append(g),B()&&f.append(a("<li>").addClass(d.collapse&&A()?"collapse in":"").append(c)),"default"===d.toolbarPlacement&&f.append(g),A()&&f.append(a("<li>").addClass(d.collapse&&B()?"collapse":"").append(e)),"bottom"===d.toolbarPlacement&&f.append(g),b.append(f))},H=function(){var b,e={};return b=c.is("input")||d.inline?c.data():c.find("input").data(),b.dateOptions&&b.dateOptions instanceof Object&&(e=a.extend(!0,e,b.dateOptions)),a.each(d,function(a){var c="date"+a.charAt(0).toUpperCase()+a.slice(1);void 0!==b[c]&&(e[a]=b[c])}),e},I=function(){var b,e=(n||c).position(),f=(n||c).offset(),g=d.widgetPositioning.vertical,h=d.widgetPositioning.horizontal;if(d.widgetParent)b=d.widgetParent.append(o);else if(c.is("input"))b=c.after(o).parent();else{if(d.inline)return void(b=c.append(o));b=c,c.children().first().after(o)}if("auto"===g&&(g=f.top+1.5*o.height()>=a(window).height()+a(window).scrollTop()&&o.height()+c.outerHeight()<f.top?"top":"bottom"),"auto"===h&&(h=b.width()<f.left+o.outerWidth()/2&&f.left+o.outerWidth()>a(window).width()?"right":"left"),"top"===g?o.addClass("top").removeClass("bottom"):o.addClass("bottom").removeClass("top"),"right"===h?o.addClass("pull-right"):o.removeClass("pull-right"),"static"===b.css("position")&&(b=b.parents().filter(function(){return"static"!==a(this).css("position")}).first()),0===b.length)throw new Error("datetimepicker component should be placed within a non-static positioned container");o.css({top:"top"===g?"auto":e.top+c.outerHeight(),bottom:"top"===g?b.outerHeight()-(b===c?0:e.top):"auto",left:"left"===h?b===c?0:e.left:"auto",right:"left"===h?"auto":b.outerWidth()-c.outerWidth()-(b===c?0:e.left)})},J=function(a){"dp.change"===a.type&&(a.date&&a.date.isSame(a.oldDate)||!a.date&&!a.oldDate)||c.trigger(a)},K=function(a){"y"===a&&(a="YYYY"),J({type:"dp.update",change:a,viewDate:f.clone()})},L=function(a){o&&(a&&(k=Math.max(p,Math.min(3,k+a))),o.find(".datepicker > div").hide().filter(".datepicker-"+q[k].clsName).show())},M=function(){var b=a("<tr>"),c=f.clone().startOf("w").startOf("d");for(d.calendarWeeks===!0&&b.append(a("<th>").addClass("cw").text("#"));c.isBefore(f.clone().endOf("w"));)b.append(a("<th>").addClass("dow").text(c.format("dd"))),c.add(1,"d");o.find(".datepicker-days thead").append(b)},N=function(a){return d.disabledDates[a.format("YYYY-MM-DD")]===!0},O=function(a){return d.enabledDates[a.format("YYYY-MM-DD")]===!0},P=function(a){return d.disabledHours[a.format("H")]===!0},Q=function(a){return d.enabledHours[a.format("H")]===!0},R=function(b,c){if(!b.isValid())return!1;if(d.disabledDates&&"d"===c&&N(b))return!1;if(d.enabledDates&&"d"===c&&!O(b))return!1;if(d.minDate&&b.isBefore(d.minDate,c))return!1;if(d.maxDate&&b.isAfter(d.maxDate,c))return!1;if(d.daysOfWeekDisabled&&"d"===c&&d.daysOfWeekDisabled.indexOf(b.day())!==-1)return!1;if(d.disabledHours&&("h"===c||"m"===c||"s"===c)&&P(b))return!1;if(d.enabledHours&&("h"===c||"m"===c||"s"===c)&&!Q(b))return!1;if(d.disabledTimeIntervals&&("h"===c||"m"===c||"s"===c)){var e=!1;if(a.each(d.disabledTimeIntervals,function(){if(b.isBetween(this[0],this[1]))return e=!0,!1}),e)return!1}return!0},S=function(){for(var b=[],c=f.clone().startOf("y").startOf("d");c.isSame(f,"y");)b.push(a("<span>").attr("data-action","selectMonth").addClass("month").text(c.format("MMM"))),c.add(1,"M");o.find(".datepicker-months td").empty().append(b)},T=function(){var b=o.find(".datepicker-months"),c=b.find("th"),g=b.find("tbody").find("span");c.eq(0).find("span").attr("title",d.tooltips.prevYear),c.eq(1).attr("title",d.tooltips.selectYear),c.eq(2).find("span").attr("title",d.tooltips.nextYear),b.find(".disabled").removeClass("disabled"),R(f.clone().subtract(1,"y"),"y")||c.eq(0).addClass("disabled"),c.eq(1).text(f.year()),R(f.clone().add(1,"y"),"y")||c.eq(2).addClass("disabled"),g.removeClass("active"),e.isSame(f,"y")&&!m&&g.eq(e.month()).addClass("active"),g.each(function(b){R(f.clone().month(b),"M")||a(this).addClass("disabled")})},U=function(){var a=o.find(".datepicker-years"),b=a.find("th"),c=f.clone().subtract(5,"y"),g=f.clone().add(6,"y"),h="";for(b.eq(0).find("span").attr("title",d.tooltips.prevDecade),b.eq(1).attr("title",d.tooltips.selectDecade),b.eq(2).find("span").attr("title",d.tooltips.nextDecade),a.find(".disabled").removeClass("disabled"),d.minDate&&d.minDate.isAfter(c,"y")&&b.eq(0).addClass("disabled"),b.eq(1).text(c.year()+"-"+g.year()),d.maxDate&&d.maxDate.isBefore(g,"y")&&b.eq(2).addClass("disabled");!c.isAfter(g,"y");)h+='<span data-action="selectYear" class="year'+(c.isSame(e,"y")&&!m?" active":"")+(R(c,"y")?"":" disabled")+'">'+c.year()+"</span>",c.add(1,"y");a.find("td").html(h)},V=function(){var a,c=o.find(".datepicker-decades"),g=c.find("th"),h=b({y:f.year()-f.year()%100-1}),i=h.clone().add(100,"y"),j=h.clone(),k=!1,l=!1,m="";for(g.eq(0).find("span").attr("title",d.tooltips.prevCentury),g.eq(2).find("span").attr("title",d.tooltips.nextCentury),c.find(".disabled").removeClass("disabled"),(h.isSame(b({y:1900}))||d.minDate&&d.minDate.isAfter(h,"y"))&&g.eq(0).addClass("disabled"),g.eq(1).text(h.year()+"-"+i.year()),(h.isSame(b({y:2e3}))||d.maxDate&&d.maxDate.isBefore(i,"y"))&&g.eq(2).addClass("disabled");!h.isAfter(i,"y");)a=h.year()+12,k=d.minDate&&d.minDate.isAfter(h,"y")&&d.minDate.year()<=a,l=d.maxDate&&d.maxDate.isAfter(h,"y")&&d.maxDate.year()<=a,m+='<span data-action="selectDecade" class="decade'+(e.isAfter(h)&&e.year()<=a?" active":"")+(R(h,"y")||k||l?"":" disabled")+'" data-selection="'+(h.year()+6)+'">'+(h.year()+1)+" - "+(h.year()+12)+"</span>",h.add(12,"y");m+="<span></span><span></span><span></span>",c.find("td").html(m),g.eq(1).text(j.year()+1+"-"+h.year())},W=function(){var b,c,g,h=o.find(".datepicker-days"),i=h.find("th"),j=[],k=[];if(B()){for(i.eq(0).find("span").attr("title",d.tooltips.prevMonth),i.eq(1).attr("title",d.tooltips.selectMonth),i.eq(2).find("span").attr("title",d.tooltips.nextMonth),h.find(".disabled").removeClass("disabled"),i.eq(1).text(f.format(d.dayViewHeaderFormat)),R(f.clone().subtract(1,"M"),"M")||i.eq(0).addClass("disabled"),R(f.clone().add(1,"M"),"M")||i.eq(2).addClass("disabled"),b=f.clone().startOf("M").startOf("w").startOf("d"),g=0;g<42;g++)0===b.weekday()&&(c=a("<tr>"),d.calendarWeeks&&c.append('<td class="cw">'+b.week()+"</td>"),j.push(c)),k=["day"],b.isBefore(f,"M")&&k.push("old"),b.isAfter(f,"M")&&k.push("new"),b.isSame(e,"d")&&!m&&k.push("active"),R(b,"d")||k.push("disabled"),b.isSame(y(),"d")&&k.push("today"),0!==b.day()&&6!==b.day()||k.push("weekend"),J({type:"dp.classify",date:b,classNames:k}),c.append('<td data-action="selectDay" data-day="'+b.format("L")+'" class="'+k.join(" ")+'">'+b.date()+"</td>"),b.add(1,"d");h.find("tbody").empty().append(j),T(),U(),V()}},X=function(){var b=o.find(".timepicker-hours table"),c=f.clone().startOf("d"),d=[],e=a("<tr>");for(f.hour()>11&&!h&&c.hour(12);c.isSame(f,"d")&&(h||f.hour()<12&&c.hour()<12||f.hour()>11);)c.hour()%4===0&&(e=a("<tr>"),d.push(e)),e.append('<td data-action="selectHour" class="hour'+(R(c,"h")?"":" disabled")+'">'+c.format(h?"HH":"hh")+"</td>"),c.add(1,"h");b.empty().append(d)},Y=function(){for(var b=o.find(".timepicker-minutes table"),c=f.clone().startOf("h"),e=[],g=a("<tr>"),h=1===d.stepping?5:d.stepping;f.isSame(c,"h");)c.minute()%(4*h)===0&&(g=a("<tr>"),e.push(g)),g.append('<td data-action="selectMinute" class="minute'+(R(c,"m")?"":" disabled")+'">'+c.format("mm")+"</td>"),c.add(h,"m");b.empty().append(e)},Z=function(){for(var b=o.find(".timepicker-seconds table"),c=f.clone().startOf("m"),d=[],e=a("<tr>");f.isSame(c,"m");)c.second()%20===0&&(e=a("<tr>"),d.push(e)),e.append('<td data-action="selectSecond" class="second'+(R(c,"s")?"":" disabled")+'">'+c.format("ss")+"</td>"),c.add(5,"s");b.empty().append(d)},$=function(){var a,b,c=o.find(".timepicker span[data-time-component]");h||(a=o.find(".timepicker [data-action=togglePeriod]"),b=e.clone().add(e.hours()>=12?-12:12,"h"),a.text(e.format("A")),R(b,"h")?a.removeClass("disabled"):a.addClass("disabled")),c.filter("[data-time-component=hours]").text(e.format(h?"HH":"hh")),c.filter("[data-time-component=minutes]").text(e.format("mm")),c.filter("[data-time-component=seconds]").text(e.format("ss")),X(),Y(),Z()},_=function(){o&&(W(),$())},aa=function(a){var b=m?null:e;if(!a)return m=!0,g.val(""),c.data("date",""),J({type:"dp.change",date:!1,oldDate:b}),void _();if(a=a.clone().locale(d.locale),x()&&a.tz(d.timeZone),1!==d.stepping)for(a.minutes(Math.round(a.minutes()/d.stepping)*d.stepping).seconds(0);d.minDate&&a.isBefore(d.minDate);)a.add(d.stepping,"minutes");R(a)?(e=a,f=e.clone(),g.val(e.format(i)),c.data("date",e.format(i)),m=!1,_(),J({type:"dp.change",date:e.clone(),oldDate:b})):(d.keepInvalid?J({type:"dp.change",date:a,oldDate:b}):g.val(m?"":e.format(i)),J({type:"dp.error",date:a,oldDate:b}))},ba=function(){var b=!1;return o?(o.find(".collapse").each(function(){var c=a(this).data("collapse");return!c||!c.transitioning||(b=!0,!1)}),b?l:(n&&n.hasClass("btn")&&n.toggleClass("active"),o.hide(),a(window).off("resize",I),o.off("click","[data-action]"),o.off("mousedown",!1),o.remove(),o=!1,J({type:"dp.hide",date:e.clone()}),g.blur(),f=e.clone(),l)):l},ca=function(){aa(null)},da=function(a){return void 0===d.parseInputDate?(!b.isMoment(a)||a instanceof Date)&&(a=y(a)):a=d.parseInputDate(a),a},ea={next:function(){var a=q[k].navFnc;f.add(q[k].navStep,a),W(),K(a)},previous:function(){var a=q[k].navFnc;f.subtract(q[k].navStep,a),W(),K(a)},pickerSwitch:function(){L(1)},selectMonth:function(b){var c=a(b.target).closest("tbody").find("span").index(a(b.target));f.month(c),k===p?(aa(e.clone().year(f.year()).month(f.month())),d.inline||ba()):(L(-1),W()),K("M")},selectYear:function(b){var c=parseInt(a(b.target).text(),10)||0;f.year(c),k===p?(aa(e.clone().year(f.year())),d.inline||ba()):(L(-1),W()),K("YYYY")},selectDecade:function(b){var c=parseInt(a(b.target).data("selection"),10)||0;f.year(c),k===p?(aa(e.clone().year(f.year())),d.inline||ba()):(L(-1),W()),K("YYYY")},selectDay:function(b){var c=f.clone();a(b.target).is(".old")&&c.subtract(1,"M"),a(b.target).is(".new")&&c.add(1,"M"),aa(c.date(parseInt(a(b.target).text(),10))),A()||d.keepOpen||d.inline||ba()},incrementHours:function(){var a=e.clone().add(1,"h");R(a,"h")&&aa(a)},incrementMinutes:function(){var a=e.clone().add(d.stepping,"m");R(a,"m")&&aa(a)},incrementSeconds:function(){var a=e.clone().add(1,"s");R(a,"s")&&aa(a)},decrementHours:function(){var a=e.clone().subtract(1,"h");R(a,"h")&&aa(a)},decrementMinutes:function(){var a=e.clone().subtract(d.stepping,"m");R(a,"m")&&aa(a)},decrementSeconds:function(){var a=e.clone().subtract(1,"s");R(a,"s")&&aa(a)},togglePeriod:function(){aa(e.clone().add(e.hours()>=12?-12:12,"h"))},togglePicker:function(b){var c,e=a(b.target),f=e.closest("ul"),g=f.find(".in"),h=f.find(".collapse:not(.in)");if(g&&g.length){if(c=g.data("collapse"),c&&c.transitioning)return;g.collapse?(g.collapse("hide"),h.collapse("show")):(g.removeClass("in"),h.addClass("in")),e.is("span")?e.toggleClass(d.icons.time+" "+d.icons.date):e.find("span").toggleClass(d.icons.time+" "+d.icons.date)}},showPicker:function(){o.find(".timepicker > div:not(.timepicker-picker)").hide(),o.find(".timepicker .timepicker-picker").show()},showHours:function(){o.find(".timepicker .timepicker-picker").hide(),o.find(".timepicker .timepicker-hours").show()},showMinutes:function(){o.find(".timepicker .timepicker-picker").hide(),o.find(".timepicker .timepicker-minutes").show()},showSeconds:function(){o.find(".timepicker .timepicker-picker").hide(),o.find(".timepicker .timepicker-seconds").show()},selectHour:function(b){var c=parseInt(a(b.target).text(),10);h||(e.hours()>=12?12!==c&&(c+=12):12===c&&(c=0)),aa(e.clone().hours(c)),ea.showPicker.call(l)},selectMinute:function(b){aa(e.clone().minutes(parseInt(a(b.target).text(),10))),ea.showPicker.call(l)},selectSecond:function(b){aa(e.clone().seconds(parseInt(a(b.target).text(),10))),ea.showPicker.call(l)},clear:ca,today:function(){var a=y();R(a,"d")&&aa(a)},close:ba},fa=function(b){return!a(b.currentTarget).is(".disabled")&&(ea[a(b.currentTarget).data("action")].apply(l,arguments),!1)},ga=function(){var b,c={year:function(a){return a.month(0).date(1).hours(0).seconds(0).minutes(0)},month:function(a){return a.date(1).hours(0).seconds(0).minutes(0)},day:function(a){return a.hours(0).seconds(0).minutes(0)},hour:function(a){return a.seconds(0).minutes(0)},minute:function(a){return a.seconds(0)}};return g.prop("disabled")||!d.ignoreReadonly&&g.prop("readonly")||o?l:(void 0!==g.val()&&0!==g.val().trim().length?aa(da(g.val().trim())):m&&d.useCurrent&&(d.inline||g.is("input")&&0===g.val().trim().length)&&(b=y(),"string"==typeof d.useCurrent&&(b=c[d.useCurrent](b)),aa(b)),o=G(),M(),S(),o.find(".timepicker-hours").hide(),o.find(".timepicker-minutes").hide(),o.find(".timepicker-seconds").hide(),_(),L(),a(window).on("resize",I),o.on("click","[data-action]",fa),o.on("mousedown",!1),n&&n.hasClass("btn")&&n.toggleClass("active"),I(),o.show(),d.focusOnShow&&!g.is(":focus")&&g.focus(),J({type:"dp.show"}),l)},ha=function(){return o?ba():ga()},ia=function(a){var b,c,e,f,g=null,h=[],i={},j=a.which,k="p";w[j]=k;for(b in w)w.hasOwnProperty(b)&&w[b]===k&&(h.push(b),parseInt(b,10)!==j&&(i[b]=!0));for(b in d.keyBinds)if(d.keyBinds.hasOwnProperty(b)&&"function"==typeof d.keyBinds[b]&&(e=b.split(" "),e.length===h.length&&v[j]===e[e.length-1])){for(f=!0,c=e.length-2;c>=0;c--)if(!(v[e[c]]in i)){f=!1;break}if(f){g=d.keyBinds[b];break}}g&&(g.call(l,o),a.stopPropagation(),a.preventDefault())},ja=function(a){w[a.which]="r",a.stopPropagation(),a.preventDefault()},ka=function(b){var c=a(b.target).val().trim(),d=c?da(c):null;return aa(d),b.stopImmediatePropagation(),!1},la=function(){g.on({change:ka,blur:d.debug?"":ba,keydown:ia,keyup:ja,focus:d.allowInputToggle?ga:""}),c.is("input")?g.on({focus:ga}):n&&(n.on("click",ha),n.on("mousedown",!1))},ma=function(){g.off({change:ka,blur:blur,keydown:ia,keyup:ja,focus:d.allowInputToggle?ba:""}),c.is("input")?g.off({focus:ga}):n&&(n.off("click",ha),n.off("mousedown",!1))},na=function(b){var c={};return a.each(b,function(){var a=da(this);a.isValid()&&(c[a.format("YYYY-MM-DD")]=!0)}),!!Object.keys(c).length&&c},oa=function(b){var c={};return a.each(b,function(){c[this]=!0}),!!Object.keys(c).length&&c},pa=function(){var a=d.format||"L LT";i=a.replace(/(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g,function(a){var b=e.localeData().longDateFormat(a)||a;return b.replace(/(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g,function(a){return e.localeData().longDateFormat(a)||a})}),j=d.extraFormats?d.extraFormats.slice():[],j.indexOf(a)<0&&j.indexOf(i)<0&&j.push(i),h=i.toLowerCase().indexOf("a")<1&&i.replace(/\[.*?\]/g,"").indexOf("h")<1,z("y")&&(p=2),z("M")&&(p=1),z("d")&&(p=0),k=Math.max(p,k),m||aa(e)};if(l.destroy=function(){ba(),ma(),c.removeData("DateTimePicker"),c.removeData("date")},l.toggle=ha,l.show=ga,l.hide=ba,l.disable=function(){return ba(),n&&n.hasClass("btn")&&n.addClass("disabled"),g.prop("disabled",!0),l},l.enable=function(){return n&&n.hasClass("btn")&&n.removeClass("disabled"),g.prop("disabled",!1),l},l.ignoreReadonly=function(a){if(0===arguments.length)return d.ignoreReadonly;if("boolean"!=typeof a)throw new TypeError("ignoreReadonly () expects a boolean parameter");return d.ignoreReadonly=a,l},l.options=function(b){if(0===arguments.length)return a.extend(!0,{},d);if(!(b instanceof Object))throw new TypeError("options() options parameter should be an object");return a.extend(!0,d,b),a.each(d,function(a,b){if(void 0===l[a])throw new TypeError("option "+a+" is not recognized!");l[a](b)}),l},l.date=function(a){if(0===arguments.length)return m?null:e.clone();if(!(null===a||"string"==typeof a||b.isMoment(a)||a instanceof Date))throw new TypeError("date() parameter must be one of [null, string, moment or Date]");return aa(null===a?null:da(a)),l},l.format=function(a){if(0===arguments.length)return d.format;if("string"!=typeof a&&("boolean"!=typeof a||a!==!1))throw new TypeError("format() expects a string or boolean:false parameter "+a);return d.format=a,i&&pa(),l},l.timeZone=function(a){if(0===arguments.length)return d.timeZone;if("string"!=typeof a)throw new TypeError("newZone() expects a string parameter");return d.timeZone=a,l},l.dayViewHeaderFormat=function(a){if(0===arguments.length)return d.dayViewHeaderFormat;if("string"!=typeof a)throw new TypeError("dayViewHeaderFormat() expects a string parameter");return d.dayViewHeaderFormat=a,l},l.extraFormats=function(a){if(0===arguments.length)return d.extraFormats;if(a!==!1&&!(a instanceof Array))throw new TypeError("extraFormats() expects an array or false parameter");return d.extraFormats=a,j&&pa(),l},l.disabledDates=function(b){if(0===arguments.length)return d.disabledDates?a.extend({},d.disabledDates):d.disabledDates;if(!b)return d.disabledDates=!1,_(),l;if(!(b instanceof Array))throw new TypeError("disabledDates() expects an array parameter");return d.disabledDates=na(b),d.enabledDates=!1,_(),l},l.enabledDates=function(b){if(0===arguments.length)return d.enabledDates?a.extend({},d.enabledDates):d.enabledDates;if(!b)return d.enabledDates=!1,_(),l;if(!(b instanceof Array))throw new TypeError("enabledDates() expects an array parameter");return d.enabledDates=na(b),d.disabledDates=!1,_(),l},l.daysOfWeekDisabled=function(a){if(0===arguments.length)return d.daysOfWeekDisabled.splice(0);if("boolean"==typeof a&&!a)return d.daysOfWeekDisabled=!1,_(),l;if(!(a instanceof Array))throw new TypeError("daysOfWeekDisabled() expects an array parameter");if(d.daysOfWeekDisabled=a.reduce(function(a,b){return b=parseInt(b,10),b>6||b<0||isNaN(b)?a:(a.indexOf(b)===-1&&a.push(b),a)},[]).sort(),d.useCurrent&&!d.keepInvalid){for(var b=0;!R(e,"d");){if(e.add(1,"d"),31===b)throw"Tried 31 times to find a valid date";b++}aa(e)}return _(),l},l.maxDate=function(a){if(0===arguments.length)return d.maxDate?d.maxDate.clone():d.maxDate;if("boolean"==typeof a&&a===!1)return d.maxDate=!1,_(),l;"string"==typeof a&&("now"!==a&&"moment"!==a||(a=y()));var b=da(a);if(!b.isValid())throw new TypeError("maxDate() Could not parse date parameter: "+a);if(d.minDate&&b.isBefore(d.minDate))throw new TypeError("maxDate() date parameter is before options.minDate: "+b.format(i));return d.maxDate=b,d.useCurrent&&!d.keepInvalid&&e.isAfter(a)&&aa(d.maxDate),f.isAfter(b)&&(f=b.clone().subtract(d.stepping,"m")),_(),l},l.minDate=function(a){if(0===arguments.length)return d.minDate?d.minDate.clone():d.minDate;if("boolean"==typeof a&&a===!1)return d.minDate=!1,_(),l;"string"==typeof a&&("now"!==a&&"moment"!==a||(a=y()));var b=da(a);if(!b.isValid())throw new TypeError("minDate() Could not parse date parameter: "+a);if(d.maxDate&&b.isAfter(d.maxDate))throw new TypeError("minDate() date parameter is after options.maxDate: "+b.format(i));return d.minDate=b,d.useCurrent&&!d.keepInvalid&&e.isBefore(a)&&aa(d.minDate),f.isBefore(b)&&(f=b.clone().add(d.stepping,"m")),_(),l},l.defaultDate=function(a){if(0===arguments.length)return d.defaultDate?d.defaultDate.clone():d.defaultDate;if(!a)return d.defaultDate=!1,l;"string"==typeof a&&(a="now"===a||"moment"===a?y():y(a));var b=da(a);if(!b.isValid())throw new TypeError("defaultDate() Could not parse date parameter: "+a);if(!R(b))throw new TypeError("defaultDate() date passed is invalid according to component setup validations");return d.defaultDate=b,(d.defaultDate&&d.inline||""===g.val().trim())&&aa(d.defaultDate),l},l.locale=function(a){if(0===arguments.length)return d.locale;if(!b.localeData(a))throw new TypeError("locale() locale "+a+" is not loaded from moment locales!");return d.locale=a,e.locale(d.locale),f.locale(d.locale),i&&pa(),o&&(ba(),ga()),l},l.stepping=function(a){return 0===arguments.length?d.stepping:(a=parseInt(a,10),(isNaN(a)||a<1)&&(a=1),d.stepping=a,l)},l.useCurrent=function(a){var b=["year","month","day","hour","minute"];if(0===arguments.length)return d.useCurrent;if("boolean"!=typeof a&&"string"!=typeof a)throw new TypeError("useCurrent() expects a boolean or string parameter");if("string"==typeof a&&b.indexOf(a.toLowerCase())===-1)throw new TypeError("useCurrent() expects a string parameter of "+b.join(", "));return d.useCurrent=a,l},l.collapse=function(a){if(0===arguments.length)return d.collapse;if("boolean"!=typeof a)throw new TypeError("collapse() expects a boolean parameter");return d.collapse===a?l:(d.collapse=a,o&&(ba(),ga()),l)},l.icons=function(b){if(0===arguments.length)return a.extend({},d.icons);if(!(b instanceof Object))throw new TypeError("icons() expects parameter to be an Object");return a.extend(d.icons,b),o&&(ba(),ga()),l},l.tooltips=function(b){if(0===arguments.length)return a.extend({},d.tooltips);if(!(b instanceof Object))throw new TypeError("tooltips() expects parameter to be an Object");return a.extend(d.tooltips,b),o&&(ba(),ga()),l},l.useStrict=function(a){if(0===arguments.length)return d.useStrict;if("boolean"!=typeof a)throw new TypeError("useStrict() expects a boolean parameter");return d.useStrict=a,l},l.sideBySide=function(a){if(0===arguments.length)return d.sideBySide;if("boolean"!=typeof a)throw new TypeError("sideBySide() expects a boolean parameter");return d.sideBySide=a,o&&(ba(),ga()),l},l.viewMode=function(a){if(0===arguments.length)return d.viewMode;if("string"!=typeof a)throw new TypeError("viewMode() expects a string parameter");if(r.indexOf(a)===-1)throw new TypeError("viewMode() parameter must be one of ("+r.join(", ")+") value");return d.viewMode=a,k=Math.max(r.indexOf(a),p),L(),l},l.toolbarPlacement=function(a){if(0===arguments.length)return d.toolbarPlacement;if("string"!=typeof a)throw new TypeError("toolbarPlacement() expects a string parameter");if(u.indexOf(a)===-1)throw new TypeError("toolbarPlacement() parameter must be one of ("+u.join(", ")+") value");return d.toolbarPlacement=a,o&&(ba(),ga()),l},l.widgetPositioning=function(b){if(0===arguments.length)return a.extend({},d.widgetPositioning);if("[object Object]"!=={}.toString.call(b))throw new TypeError("widgetPositioning() expects an object variable");if(b.horizontal){if("string"!=typeof b.horizontal)throw new TypeError("widgetPositioning() horizontal variable must be a string");if(b.horizontal=b.horizontal.toLowerCase(),t.indexOf(b.horizontal)===-1)throw new TypeError("widgetPositioning() expects horizontal parameter to be one of ("+t.join(", ")+")");d.widgetPositioning.horizontal=b.horizontal}if(b.vertical){if("string"!=typeof b.vertical)throw new TypeError("widgetPositioning() vertical variable must be a string");if(b.vertical=b.vertical.toLowerCase(),s.indexOf(b.vertical)===-1)throw new TypeError("widgetPositioning() expects vertical parameter to be one of ("+s.join(", ")+")");d.widgetPositioning.vertical=b.vertical}return _(),l},l.calendarWeeks=function(a){if(0===arguments.length)return d.calendarWeeks;if("boolean"!=typeof a)throw new TypeError("calendarWeeks() expects parameter to be a boolean value");return d.calendarWeeks=a,_(),l},l.showTodayButton=function(a){if(0===arguments.length)return d.showTodayButton;if("boolean"!=typeof a)throw new TypeError("showTodayButton() expects a boolean parameter");return d.showTodayButton=a,o&&(ba(),ga()),l},l.showClear=function(a){if(0===arguments.length)return d.showClear;if("boolean"!=typeof a)throw new TypeError("showClear() expects a boolean parameter");return d.showClear=a,o&&(ba(),ga()),l},l.widgetParent=function(b){if(0===arguments.length)return d.widgetParent;if("string"==typeof b&&(b=a(b)),null!==b&&"string"!=typeof b&&!(b instanceof a))throw new TypeError("widgetParent() expects a string or a jQuery object parameter");return d.widgetParent=b,o&&(ba(),ga()),l},l.keepOpen=function(a){if(0===arguments.length)return d.keepOpen;if("boolean"!=typeof a)throw new TypeError("keepOpen() expects a boolean parameter");return d.keepOpen=a,l},l.focusOnShow=function(a){if(0===arguments.length)return d.focusOnShow;if("boolean"!=typeof a)throw new TypeError("focusOnShow() expects a boolean parameter");return d.focusOnShow=a,l},l.inline=function(a){if(0===arguments.length)return d.inline;if("boolean"!=typeof a)throw new TypeError("inline() expects a boolean parameter");return d.inline=a,l},l.clear=function(){return ca(),l},l.keyBinds=function(a){return 0===arguments.length?d.keyBinds:(d.keyBinds=a,l)},l.getMoment=function(a){return y(a)},l.debug=function(a){if("boolean"!=typeof a)throw new TypeError("debug() expects a boolean parameter");return d.debug=a,l},l.allowInputToggle=function(a){if(0===arguments.length)return d.allowInputToggle;if("boolean"!=typeof a)throw new TypeError("allowInputToggle() expects a boolean parameter");return d.allowInputToggle=a,l},l.showClose=function(a){if(0===arguments.length)return d.showClose;if("boolean"!=typeof a)throw new TypeError("showClose() expects a boolean parameter");return d.showClose=a,l},l.keepInvalid=function(a){if(0===arguments.length)return d.keepInvalid;if("boolean"!=typeof a)throw new TypeError("keepInvalid() expects a boolean parameter");
return d.keepInvalid=a,l},l.datepickerInput=function(a){if(0===arguments.length)return d.datepickerInput;if("string"!=typeof a)throw new TypeError("datepickerInput() expects a string parameter");return d.datepickerInput=a,l},l.parseInputDate=function(a){if(0===arguments.length)return d.parseInputDate;if("function"!=typeof a)throw new TypeError("parseInputDate() sholud be as function");return d.parseInputDate=a,l},l.disabledTimeIntervals=function(b){if(0===arguments.length)return d.disabledTimeIntervals?a.extend({},d.disabledTimeIntervals):d.disabledTimeIntervals;if(!b)return d.disabledTimeIntervals=!1,_(),l;if(!(b instanceof Array))throw new TypeError("disabledTimeIntervals() expects an array parameter");return d.disabledTimeIntervals=b,_(),l},l.disabledHours=function(b){if(0===arguments.length)return d.disabledHours?a.extend({},d.disabledHours):d.disabledHours;if(!b)return d.disabledHours=!1,_(),l;if(!(b instanceof Array))throw new TypeError("disabledHours() expects an array parameter");if(d.disabledHours=oa(b),d.enabledHours=!1,d.useCurrent&&!d.keepInvalid){for(var c=0;!R(e,"h");){if(e.add(1,"h"),24===c)throw"Tried 24 times to find a valid date";c++}aa(e)}return _(),l},l.enabledHours=function(b){if(0===arguments.length)return d.enabledHours?a.extend({},d.enabledHours):d.enabledHours;if(!b)return d.enabledHours=!1,_(),l;if(!(b instanceof Array))throw new TypeError("enabledHours() expects an array parameter");if(d.enabledHours=oa(b),d.disabledHours=!1,d.useCurrent&&!d.keepInvalid){for(var c=0;!R(e,"h");){if(e.add(1,"h"),24===c)throw"Tried 24 times to find a valid date";c++}aa(e)}return _(),l},l.viewDate=function(a){if(0===arguments.length)return f.clone();if(!a)return f=e.clone(),l;if(!("string"==typeof a||b.isMoment(a)||a instanceof Date))throw new TypeError("viewDate() parameter must be one of [string, moment or Date]");return f=da(a),K(),l},c.is("input"))g=c;else if(g=c.find(d.datepickerInput),0===g.length)g=c.find("input");else if(!g.is("input"))throw new Error('CSS class "'+d.datepickerInput+'" cannot be applied to non input element');if(c.hasClass("input-group")&&(n=0===c.find(".datepickerbutton").length?c.find(".input-group-addon"):c.find(".datepickerbutton")),!d.inline&&!g.is("input"))throw new Error("Could not initialize DateTimePicker without an input element");return e=y(),f=e.clone(),a.extend(!0,d,H()),l.options(d),pa(),la(),g.prop("disabled")&&l.disable(),g.is("input")&&0!==g.val().trim().length?aa(da(g.val().trim())):d.defaultDate&&void 0===g.attr("placeholder")&&aa(d.defaultDate),d.inline&&ga(),l};return a.fn.datetimepicker=function(b){b=b||{};var d,e=Array.prototype.slice.call(arguments,1),f=!0,g=["destroy","hide","show","toggle"];if("object"==typeof b)return this.each(function(){var d,e=a(this);e.data("DateTimePicker")||(d=a.extend(!0,{},a.fn.datetimepicker.defaults,b),e.data("DateTimePicker",c(e,d)))});if("string"==typeof b)return this.each(function(){var c=a(this),g=c.data("DateTimePicker");if(!g)throw new Error('bootstrap-datetimepicker("'+b+'") method was called on an element that is not using DateTimePicker');d=g[b].apply(g,e),f=d===g}),f||a.inArray(b,g)>-1?this:d;throw new TypeError("Invalid arguments for DateTimePicker: "+b)},a.fn.datetimepicker.defaults={timeZone:"",format:!1,dayViewHeaderFormat:"MMMM YYYY",extraFormats:!1,stepping:1,minDate:!1,maxDate:!1,useCurrent:!0,collapse:!0,locale:b.locale(),defaultDate:!1,disabledDates:!1,enabledDates:!1,icons:{time:"glyphicon glyphicon-time",date:"glyphicon glyphicon-calendar",up:"glyphicon glyphicon-chevron-up",down:"glyphicon glyphicon-chevron-down",previous:"glyphicon glyphicon-chevron-left",next:"glyphicon glyphicon-chevron-right",today:"glyphicon glyphicon-screenshot",clear:"glyphicon glyphicon-trash",close:"glyphicon glyphicon-remove"},tooltips:{today:"Go to today",clear:"Clear selection",close:"Close the picker",selectMonth:"Select Month",prevMonth:"Previous Month",nextMonth:"Next Month",selectYear:"Select Year",prevYear:"Previous Year",nextYear:"Next Year",selectDecade:"Select Decade",prevDecade:"Previous Decade",nextDecade:"Next Decade",prevCentury:"Previous Century",nextCentury:"Next Century",pickHour:"Pick Hour",incrementHour:"Increment Hour",decrementHour:"Decrement Hour",pickMinute:"Pick Minute",incrementMinute:"Increment Minute",decrementMinute:"Decrement Minute",pickSecond:"Pick Second",incrementSecond:"Increment Second",decrementSecond:"Decrement Second",togglePeriod:"Toggle Period",selectTime:"Select Time"},useStrict:!1,sideBySide:!1,daysOfWeekDisabled:!1,calendarWeeks:!1,viewMode:"days",toolbarPlacement:"default",showTodayButton:!1,showClear:!1,showClose:!1,widgetPositioning:{horizontal:"auto",vertical:"auto"},widgetParent:null,ignoreReadonly:!1,keepOpen:!1,focusOnShow:!0,inline:!1,keepInvalid:!1,datepickerInput:".datepickerinput",keyBinds:{up:function(a){if(a){var b=this.date()||this.getMoment();a.find(".datepicker").is(":visible")?this.date(b.clone().subtract(7,"d")):this.date(b.clone().add(this.stepping(),"m"))}},down:function(a){if(!a)return void this.show();var b=this.date()||this.getMoment();a.find(".datepicker").is(":visible")?this.date(b.clone().add(7,"d")):this.date(b.clone().subtract(this.stepping(),"m"))},"control up":function(a){if(a){var b=this.date()||this.getMoment();a.find(".datepicker").is(":visible")?this.date(b.clone().subtract(1,"y")):this.date(b.clone().add(1,"h"))}},"control down":function(a){if(a){var b=this.date()||this.getMoment();a.find(".datepicker").is(":visible")?this.date(b.clone().add(1,"y")):this.date(b.clone().subtract(1,"h"))}},left:function(a){if(a){var b=this.date()||this.getMoment();a.find(".datepicker").is(":visible")&&this.date(b.clone().subtract(1,"d"))}},right:function(a){if(a){var b=this.date()||this.getMoment();a.find(".datepicker").is(":visible")&&this.date(b.clone().add(1,"d"))}},pageUp:function(a){if(a){var b=this.date()||this.getMoment();a.find(".datepicker").is(":visible")&&this.date(b.clone().subtract(1,"M"))}},pageDown:function(a){if(a){var b=this.date()||this.getMoment();a.find(".datepicker").is(":visible")&&this.date(b.clone().add(1,"M"))}},enter:function(){this.hide()},escape:function(){this.hide()},"control space":function(a){a&&a.find(".timepicker").is(":visible")&&a.find('.btn[data-action="togglePeriod"]').click()},t:function(){this.date(this.getMoment())},delete:function(){this.clear()}},debug:!1,allowInputToggle:!1,disabledTimeIntervals:!1,disabledHours:!1,enabledHours:!1,viewDate:!1},a.fn.datetimepicker});
if (window.location.pathname === '/checkout/') {
    

   // Listen for error on billing / shipping form fields AJAX call
/*    jQuery(document).ajaxComplete(function (event, xhr, settings) {
        var result = xhr.responseJSON.result;
        if (result === 'failure') {
            var input = jQuery('input[name=woocommerce_checkout_place_order]');
            input.val('Place order');
            input.prop('disabled', false);
        }
    });*/

    var checkout_form = $('form.checkout');

	checkout_form.on('checkout_place_order', function () {
		if(jQuery('div#gift-certificate-receiver-form-single')){
          var gc_input_arr = [];
            jQuery('div#gift-certificate-receiver-form-single').find('input[type="text"]').each(function(e) {
              if($(this).val() == ''){ gc_input_arr.push(0); }else{ gc_input_arr.push(1);  }
            });

            if(gc_input_arr[0] == 0 && gc_input_arr[1] == 0 && gc_input_arr[2] == 0){
            	jQuery('div#customer_details').before('<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout"><ul class="woocommerce-error" role="alert"><li data-id="gift_receiver_name"><strong>Gift Receiver Name</strong> is a required field.		</li><li data-id="gift_sender_name"><strong>Gift Sender Name</strong> is a required field.</li><li data-id="gift_receiver_email"><strong>Gift Receiver Email</strong> is a required field.</li></ul></div>');
	            	jQuery('html, body').animate({
									        scrollTop: $(".page").offset().top
									    }, 1500);

						setTimeout(function () {
					    jQuery("div.woocommerce-NoticeGroup-checkout").remove();
					}, 7000);

            	return false;
            }else  if(gc_input_arr[0] == 0 || gc_input_arr[1] == 0 || gc_input_arr[2] == 0){
            	if(gc_input_arr[0] == 0){
            		jQuery('div#customer_details').before('<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout"><ul class="woocommerce-error" role="alert"><li data-id="gift_receiver_name"><strong>Gift Receiver Name</strong> is a required field.		</li></ul></div>');	
            	}else if(gc_input_arr[1] == 0){
            		jQuery('div#customer_details').before('<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout"><ul class="woocommerce-error" role="alert"><li data-id="gift_sender_name"><strong>Gift Sender Name</strong> is a required field.		</li></ul></div>');	
            	}else if(gc_input_arr[2] == 0){
            		jQuery('div#customer_details').before('<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout"><ul class="woocommerce-error" role="alert"><li data-id="gift_receiver_email"><strong>Gift Receiver Email</strong> is a required field.		</li></ul></div>');	
            	}
            	jQuery('html, body').animate({
								        scrollTop: $(".page").offset().top
								    }, 1500);

            	setTimeout(function () {
			    jQuery("div.woocommerce-NoticeGroup-checkout").remove();
			}, 7000);

            	return false;
            }else{
            	$(document.body).trigger('update_checkout');
            	return true;
            }

            

        }else{
        	$(document.body).trigger('update_checkout');	
        	return true;
        }
        
        
   	});

}

var body = jQuery("body"); 

/*setTimeout(function () {
    jQuery("button.single_add_to_cart_button").removeClass('disabled');
}, 800);*/
/* 
if(window.location.pathname === "/product/filet-mignon-lobster-tail/" ) {
    var meal_select_options = [
        "<option value=''>Choose an option</option>",
        "<option value='gourmet-meal-for-1' class='attached enabled'>Gourmet Meal for 1</option>"
    ];

    $('select#pa_meal-size').each(function () {
        $(this).html(meal_select_options);
        $(this).val('gourmet-meal-for-1');
        $('select#servings').val(1);
        $('select#servings').change();
    });


    body.on('change', 'select#pa_meal-size', function () {
        $("button.single_add_to_cart_button").removeClass('disabled');
        var value = $(this).val();
        if (value) {
            var number = 1;
            $('select#servings').val(number);
            $('select#servings').change();
            $(this).html(meal_select_options);
            $(this).val(value);
        }
    });
} else {
    var meal_select_options = [
        "<option value=''>Choose an option</option>",
        "<option value='gourmet-meal-for-2' class='attached enabled'>Gourmet Meal for 2</option>",
        "<option value='gourmet-meal-for-4' class='attached enabled'>Gourmet Meal for 4</option>",
        "<option value='gourmet-meal-for-6' class='attached enabled'>Gourmet Meal for 6</option>"
    ];

    $('select#pa_meal-size').each(function () {
        $(this).html(meal_select_options);
        $(this).val('gourmet-meal-for-2');
        $('select#servings').val(2);
        $('select#servings').change();
    });


    body.on('change', 'select#pa_meal-size', function () {
        $("button.single_add_to_cart_button").removeClass('disabled');
        var value = $(this).val();
        if (value) {
            var number = 2;
            if (value === 'gourmet-meal-for-4') number = 4;
            if (value === 'gourmet-meal-for-6') number = 6;
            $('select#servings').val(number);
            $('select#servings').change();
            $(this).html(meal_select_options);
            $(this).val(value);
        }
    });
} */
if (window.location.pathname === '/cart/') {
    
	
    var rc_error = jQuery('#iof-rc-wc-error');

    if(rc_error.length !== 0) {
        jQuery('.woocommerce-message').hide();
    }

    setTimeout(function () {
        jQuery("input[name='update_cart']").removeAttr("disabled");
    }, 100);

    //jQuery("[data-toggle='iof-tooltip']").tooltip();

    var maxDate = '';
    var last_selected_dates = [];
    var selected_dates = get_selected_dates();
    var all_data       = jQuery("form.woocommerce-cart-form").serialize();

    var shipping_val = jQuery("input:radio[name=shipping_method\\[0\\]]:checked").val();
    var shipping_arr = (typeof(shipping_val) != "undefined" && shipping_val !== null) ? shipping_val : 'local_pickup:24';
    var arr = shipping_arr.split(':');
    var shipping_method = arr[0];
   
    var maxDate = '';
    var last_selected_dates = [];
    var selected_dates = get_selected_dates();
    var all_data       = jQuery("form.woocommerce-cart-form").serialize();

    /*var shipping_val = jQuery("input:radio[name=shipping_method\\[0\\]]:checked").val();
   
    var shipping_arr = (typeof(shipping_val) != "undefined" && shipping_val !== null) ? shipping_val : 'local_pickup:24';
    var arr = shipping_arr.split(':');
    var shipping_method = arr[0];*/


    var zip = jQuery('#calc_shipping_postcode').val()
    jQuery.post(
        ajax_object.ajax_url,
        {
            "action": "get_all_disabled_dates",
            "selected_dates": selected_dates,
            "all_data": all_data,
            "zip": zip
        }
    )
        .done(function (data) {
            if (!data.error) {

                jQuery(".iof-datepicker").each(function () {
                    var input_element = jQuery(this);
                    var order_item_num = jQuery(this).parent().parent().prev().prev().find('.iof-order-item').val();
                    var order_item_del = jQuery(this).parent().parent().prev().prev().find('.iof-delivery-row-num').val() - 1;

                    try{
                       var date = data.selected_dates[order_item_num][order_item_del];
                    }catch(e){
                       date = '';
                    }
			   
			    	input_element.datetimepicker({
                        format: 'dddd, MMM Do YYYY',
                        allowInputToggle: true,
                        useCurrent: false,
                        defaultDate: date,
                        disabledDates: data.disabled_dates,
                        daysOfWeekDisabled: data.disabled_week_days,
                        //maxDate: data.max_date,
                        minDate: data.min_date,
                        ignoreReadonly: true,
                        debug: true
                    });

                    input_element.val(data.min_date);
                });
                var shipping_val = jQuery("input:radio[name=shipping_method\\[0\\]]:checked").val();
                if (typeof(shipping_val) != "undefined" && shipping_val !== null) {
                    // shipping methods loaded, do nothing
                } else {
                    // shipping methods not loaded, update cart
                    // if (data.zip) {
                    //     setTimeout(function () {
                    //         $('input[name=update_cart]').click();
                    //     }, 800);
                    // }
                }
            }
        })
        .fail(function (data) {
            alert('Failed to load calendar.');
        });
	
    // var cart_empty_node = $("p.cart-empty");

    // if(cart_empty_node.length === 0) {
    //     $.post(
    //         ajax_object.ajax_url,
    //         {
    //             "action": "get_all_disabled_dates",
    //             "selected_dates": selected_dates,
    //             "all_data": all_data
    //         }
    //     )
    //         .done(function (data) {
    //             if (!data.error) {
    //                 $(".iof-datepicker").each(function () {
    //                     var input_element = $(this);
    //                     var order_item_num = $(this).parent().parent().prev().prev().find('.iof-order-item').val();
    //                     var order_item_del = $(this).parent().parent().prev().prev().find('.iof-delivery-row-num').val() - 1;
    //                     var date = data.selected_dates[order_item_num][order_item_del];
    //                     input_element.datetimepicker({
    //                         format: 'dddd, MMM Do YYYY',
    //                         allowInputToggle: true,
    //                         useCurrent: false,
    //                         defaultDate: date,
    //                         disabledDates: data.disabled_dates,
    //                         daysOfWeekDisabled: data.disabled_week_days,
    //                         maxDate: data.max_date,
    //                         minDate: data.min_date,
    //                         ignoreReadonly: true
    //                     });
    //                     input_element.val(date);
    //                 });
    //                 var shipping_val = $("input:radio[name=shipping_method\\[0\\]]:checked").val();
    //                 if (typeof(shipping_val) != "undefined" && shipping_val !== null) {
    //                     // shipping methods loaded, do nothing
    //                 } else {
    //                     // shipping methods not loaded, update cart
    //                     // if (data.zip) {
    //                     //     setTimeout(function () {
    //                     //         $('input[name=update_cart]').click();
    //                     //     }, 800);
    //                     // }
    //                 }
    //             }
    //         })
    //         .fail(function (data) {
    //             alert('Failed to load calendar.');
    //         });
    // }


      body.on('propertychange keyup change input paste', 'input.qty', function () {
        var input = $(this);
        if (input.val() != '' && input.val() != input.data('old_val')) {
            input.data('old_val', input.val());
            setTimeout(function () {
                jQuery('input[name=update_cart]').click();
            }, 800);
        }
    });

    jQuery('#calc_shipping_postcode').keydown(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });

    

	jQuery(document).on('click', 'div.iof-datepicker', function(e) {
		

        var order_item_num = jQuery(this).parent().parent().parent().prev().prev().find('.iof-order-item').val();
        last_selected_dates[order_item_num] = jQuery('input.iof-delivery-date').val();
        selected_dates = get_selected_dates();
        jQuery.post(
            ajax_object.ajax_url,
            {
                "action": "get_all_disabled_dates",
                "selected_dates": selected_dates
            }
        ).done(function (data) {

           	jQuery(".iof-datepicker").each(function () {

                    var date = moment( jQuery(this).find('input.iof-delivery-date').val(), 'dddd, MMM Do YYYY');

                  	jQuery(this).datetimepicker({
                        format: 'dddd, MMM Do YYYY',
                        allowInputToggle: true,
                        useCurrent: false,
                        defaultDate: date,
                        disabledDates: data.disabled_dates,
                        minDate: data.min_date,
                        daysOfWeekDisabled: data.disabled_week_days,
                        //maxDate: data.max_date,
                        ignoreReadonly: true
                    }).on('dp.change',function(e){

                    	var lst_to1 = [];
					    jQuery("input:text.iof-delivery-date").each(function() {
					    	if($(this).val() == ''){ lst_to1.push(0); }else{ lst_to1.push(1);	 }
					    });
                         var added=false;
                        $.map(lst_to1, function(elementOfArray, indexInArray) {
                            if (elementOfArray == 0) {
                                added = true;
                             }
                        });

					    if( added ){}else{

	                         var currentProductID = jQuery(this).find('input.iof-delivery-date').data('prodid');
                            var currentProductName = jQuery(this).find('input.iof-delivery-date').data('prodname');

                            var currentProductSideId = jQuery(this).find('input.iof-delivery-date').data('sideid');
                            var currentProductSideName = jQuery(this).find('input.iof-delivery-date').data('sidename');

                            var currentProductVegId = jQuery(this).find('input.iof-delivery-date').data('vegitableid');
                            var currentProductVegName = jQuery(this).find('input.iof-delivery-date').data('vegetablename');

                            var currentProductSaladId = jQuery(this).find('input.iof-delivery-date').data('saladid');
                            var currentProductSaladName = jQuery(this).find('input.iof-delivery-date').data('saladname');

                            var currentProductDesId = jQuery(this).find('input.iof-delivery-date').data('dessertid');
                            var currentProductDesName = jQuery(this).find('input.iof-delivery-date').data('dessertname');
                            


							const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
							const d = new Date();
							var product_arr = "";
							if( monthNames[d.getMonth()] == 'December' && ( currentProductID == 1612 || currentProductID == 5588 || currentProductID == 5711 || currentProductID == 5677 || currentProductSideId == 5588 || currentProductVegId == 5711 || currentProductDesId == 5677 || currentProductVegId == 5588 || currentProductSideId == 5711 ) ){
                        
                                if(currentProductSideId == 5588){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5711){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductDesId == 5677){
                                    var product_arr = currentProductDesName;    
                                }else if(currentProductVegId == 5588){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5711){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    var product_arr = currentProductName;
                                }
                            }
                            if( monthNames[d.getMonth()] == 'February' && ( currentProductID == 1733  ||currentProductID == 5682  ||  currentProductSideId == 5682  || currentProductVegId == 5682 ) ) {

                                if(currentProductDesId == 5682){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5682){
                                    var product_arr = currentProductVegName;    
                                }else{
                                    var product_arr = currentProductName;
                                }
                            }

                             if( monthNames[d.getMonth()] == 'March' && ( currentProductID == 1662  ||currentProductID == 5687  || currentProductID == 5692 || currentProductSideId == 5687  || currentProductVegId == 5692 || currentProductSideId == 5692  || currentProductVegId == 5687  ) ) {


                                 if(currentProductSideId == 5687){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5692){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductVegId == 5687){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5692){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    var product_arr = currentProductName;
                                }

                            }
                            if( monthNames[d.getMonth()] == 'April' && ( currentProductID == 1788  ||currentProductID == 9697  || currentProductID == 5702 || currentProductSideId == 9697  || currentProductVegId == 5702 || currentProductSideId == 5702  || currentProductVegId == 9697  ) ) {

                                if(currentProductSideId == 9697){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5702){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductVegId == 9697){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5702){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    var product_arr = currentProductName;
                                }
                            }

                            if( monthNames[d.getMonth()] == 'May' && ( currentProductID == 1872  ||currentProductID == 5707  || currentProductID == 5711 || currentProductSideId == 5707  || currentProductVegId == 5711 || currentProductSideId == 5711  || currentProductVegId == 5707  ) ) {


                                if(currentProductSideId == 5707){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5711){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductVegId == 5707){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5711){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    var product_arr = currentProductName;
                                }
                            }
                            
                            if( monthNames[d.getMonth()] == 'June' && ( currentProductID == 1775  ||currentProductID == 5715  || currentProductID == 5719 || currentProductSideId == 5715  || currentProductVegId == 5719 || currentProductSideId == 5719  || currentProductVegId == 5715  ) ) {

                                if(currentProductSideId == 5715){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5719){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductVegId == 5715){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5719){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    var product_arr = currentProductName;
                                }
                            }

                            if( monthNames[d.getMonth()] == 'July' && ( currentProductID == 1918  ||currentProductID == 5723  || currentProductSideId == 5723  || currentProductVegId == 5723  ) ) {

                                if(currentProductSideId == 5723){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5723){
                                    var product_arr = currentProductVegName;    
                                }else{
                                    var product_arr = currentProductName;
                                }


                            }

                            if( monthNames[d.getMonth()] == 'August' && ( currentProductID == 1752  ||currentProductID == 5727  || currentProductID == 5732 || currentProductSideId == 5727  || currentProductVegId == 5732 || currentProductSideId == 5732  || currentProductVegId == 5727  ) ) {

                                if(currentProductSideId == 5727){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5732){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductVegId == 5727){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5732){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    var product_arr = currentProductName;
                                }

                            }
                            if( monthNames[d.getMonth()] == 'September' && ( currentProductID == 1800  ||currentProductID == 5650  || currentProductID == 5646 || currentProductSideId == 5650  || currentProductVegId == 5646 || currentProductSideId == 5646  || currentProductVegId == 5650  ) ) {

                                if(currentProductSideId == 5650){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5646){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductVegId == 5650){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5646){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    var product_arr = currentProductName;
                                }
                                
                            }
                            if( monthNames[d.getMonth()] == 'October' && (currentProductID == 4570  ||currentProductID == 5655 ||currentProductID == 30002181849  || currentProductSideId == 5655 || currentProductVegId == 30002181849 ) ) {
                               
                                if(currentProductSideId == 5655){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 30002181849){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 30002181849){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5655){
                                    var product_arr = currentProductVegName;    
                                }else{
                                    var product_arr = currentProductName;
                                }
                                
                            }
                            //November
                            if( monthNames[d.getMonth()] == 'November' && ( currentProductID == 4574 || currentProductID == 5660 || currentProductID == 5665 || currentProductID == 5823 || currentProductSideId == 5660 || currentProductVegId == 5665 || currentProductSaladId == 5823 || currentProductVegId == 5660 || currentProductSideId == 5665 ) ){

                                if(currentProductSideId == 5660){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5665){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSaladId == 5823){
                                    var product_arr = currentProductSaladName;    
                                }else if(currentProductVegId == 5660){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5665){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    if(currentProductID == 4574){
                                        var product_arr = currentProductName;    
                                    }else if(currentProductID == 5660){
                                        var product_arr = currentProductSideName;    
                                    }else if(currentProductID == 5665){
                                        var product_arr = currentProductVegName;    
                                    }else if(currentProductID == 5823){
                                        var product_arr = currentProductSaladName;    
                                    }

                                }
                                
                            }
                             if( monthNames[d.getMonth()] == 'December' && ( currentProductID == 1612 || currentProductID == 5588 || currentProductID == 5711 || currentProductID == 5677 || currentProductSideId == 5588 || currentProductVegId == 5711 || currentProductDesId == 5677 || currentProductVegId == 5588 || currentProductSideId == 5711 ) ){
                        
                                if(currentProductSideId == 5588){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5711){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductDesId == 5677){
                                    var product_arr = currentProductDesName;    
                                }else if(currentProductVegId == 5588){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5711){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    var product_arr = currentProductName;
                                }
                            }

							var selected = moment( jQuery(this).find('input.iof-delivery-date').val(), 'dddd, MMM Do YYYY'); 
					    	var tttt = new Date(selected);
							//var dataProductdatetime =  ("0" + tttt.getDate()).slice(-2) + "/" + ("0" + (tttt.getMonth() + 1)).slice(-2) + "/" + 		    tttt.getFullYear();



							var myDate = new Date();
							var firstDay = new Date(myDate.getFullYear(), myDate.getMonth(), 1);
							var lastDay = new Date(myDate.getFullYear(), myDate.getMonth() + 1, 0);
							var lastDayWithSlashes =  (lastDay.getDate()) + '/' + (lastDay.getMonth() + 1) + '/' + lastDay.getFullYear();
							var dmy = lastDayWithSlashes.split("/");
							var joindate = new Date(
							parseInt(
							    dmy[2], 10),
							    parseInt(dmy[1], 10) - 1,
							    parseInt(dmy[0], 10)
							);
							joindate.setDate(joindate.getDate() + 7);
							//var monthlySpecialLastDate =   ("0" + joindate.getDate()).slice(-2) + "/" + ("0" + (joindate.getMonth() + 1)).slice(-2) + "/" +  joindate.getFullYear();
							if(product_arr != ""){
								if( tttt.getTime() <= joindate.getTime() ) {
									jQuery("input[name='update_cart']").removeAttr("disabled");
				                    jQuery('input[name=update_cart]').click();	 
							    }else{
									jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Monthly Special ('+product_arr+') cannot be ordered past 7 days of the upcoming month.</li></ul>');
				    				 jQuery('html, body').animate({
								        scrollTop: $(".page").offset().top
								    }, 1500);
				    				jQuery('.checkout-button').addClass("disabled");
				    				$("a.checkout-button").removeAttr("href");
							    }
							}else{
								jQuery("input[name='update_cart']").removeAttr("disabled");
		                    	jQuery('input[name=update_cart]').click();	 
							}
		    				
					    }	    
                   	
                    });
                });
            })
            .fail(function (data) {
                alert('Failed to load calendar.');
            });
        });


        /*=== LIMIT ZIP MAX NUMBERS ===*/
        var calc_shipping_postcode = jQuery('#calc_shipping_postcode').val();
        body.on("keyup paste change", "#calc_shipping_postcode", function () {
              var shipping_postcode = $(this).val().length;
               if(shipping_postcode != '' && shipping_postcode == 5){
                 //jQuery('#popup-zip-btn').trigger('click');
               }else{
                if(calc_shipping_postcode == ''){
                    jQuery('span.form-row.form-row-wide.text-center').html('Please click??Update??to confirm your ZIP Code entry.');   
                }else{
                    jQuery('span.form-row.form-row-wide.text-center').html('Please click??Update??to confirm your ZIP Code entry. <BR> <i style="font-size: 10px;text-align: left; color: red;">Changing the ZIP Code may require you to re-select your delivery date(s).</i> ');
                }
                  jQuery('a.checkout-button').addClass('disabled');
                  jQuery('a.checkout-button').attr("href","#");

               }
        });

       /* jQuery(".CBShipping button[type=submit]").click(function(e) {
            e.preventDefault();
            jQuery('#popup-zip-btn').trigger('click'); 
        });


        jQuery('#popup-zip-btn').click(function(e) {
            e.preventDefault();
            var zip = jQuery('#calc_shipping_postcode').val()
             var state = jQuery('#calc_shipping_state').val()
            jQuery.post(
                ajax_object.ajax_url,
                {
                    "action": "save_checkout_zip_code",
                    "zip": zip,
                    "state": state
                }
            )
            .done(function (data) {
              jQuery('input[name=update_cart]').click();
              location.reload(true);
              return true;         
            })
           
        });
*/
		  

    body.on("click", ".iof-add-delivery", function () {
        var button = jQuery(this);
        var num = parseInt(button.parent().parent().prev().find('.iof-delivery-row-num').val());
               
       var myCartBoxKey = jQuery(this).find('.myCartBoxKey').val();
       var myCartBoxKey_arr = [];
	    $("input:hidden.myCartBoxKey").each(function() {
	    	myCartBoxKey_arr.push(1);	
	    });

	    var lst_to = [];
	    $("input:text.iof-delivery-date").each(function() {
	    	if($(this).val() == ''){ lst_to.push(0); }else{ lst_to.push(1);	 }
	    });
	    if(myCartBoxKey_arr.length > 1){
	    	if(myCartBoxKey_arr.length == 2){
	    		var myIofDeliveryDate = 10;	
	    	}else if(myCartBoxKey_arr.length == 3){
	    		var myIofDeliveryDate = 15;	
	    	}else if(myCartBoxKey_arr.length == 4){
	    		var myIofDeliveryDate = 20;	
	    	}else if(myCartBoxKey_arr.length == 5){
	    		var myIofDeliveryDate = 25;	
	    	}else if(myCartBoxKey_arr.length == 6){
	    		var myIofDeliveryDate = 30;	
	    	}else if(myCartBoxKey_arr.length == 7){
	    		var myIofDeliveryDate = 35;	
	    	}else if(myCartBoxKey_arr.length == 8){
	    		var myIofDeliveryDate = 40;	
	    	}else if(myCartBoxKey_arr.length == 9){
	    		var myIofDeliveryDate = 45;	
	    	}
	    	
	    }else{
	    	var myIofDeliveryDate = 5;
	    }

        if(num < 5){
        	if(myIofDeliveryDate == 45){
        		if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 || lst_to[5]==0 || lst_to[6]==0 || lst_to[7]==0 || lst_to[8]==0 || lst_to[9]==0 || lst_to[10]==0 || lst_to[11]==0 || lst_to[12]==0 || lst_to[13]==0 || lst_to[14]==0 || lst_to[15]==0 || lst_to[16]==0 || lst_to[17]==0 || lst_to[18]==0 || lst_to[19]==0 || lst_to[20]==0 || lst_to[21]==0 || lst_to[22]==0 || lst_to[23]==0 || lst_to[24]==0 || lst_to[25]==0 || lst_to[26]==0 || lst_to[27]==0 || lst_to[28]==0 || lst_to[29]==0 || lst_to[30]==0 || lst_to[31]==0 || lst_to[32]==0 || lst_to[33]==0 || lst_to[34]==0 || lst_to[35]==0 || lst_to[36]==0 || lst_to[37]==0 || lst_to[38]==0 || lst_to[39]==0  || lst_to[40]==0 || lst_to[41]==0 || lst_to[42]==0 || lst_to[43]==0 || lst_to[44]==0){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}

        	if(myIofDeliveryDate == 40){
        		if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 || lst_to[5]==0 || lst_to[6]==0 || lst_to[7]==0 || lst_to[8]==0 || lst_to[9]==0 || lst_to[10]==0 || lst_to[11]==0 || lst_to[12]==0 || lst_to[13]==0 || lst_to[14]==0 || lst_to[15]==0 || lst_to[16]==0 || lst_to[17]==0 || lst_to[18]==0 || lst_to[19]==0 || lst_to[20]==0 || lst_to[21]==0 || lst_to[22]==0 || lst_to[23]==0 || lst_to[24]==0 || lst_to[25]==0 || lst_to[26]==0 || lst_to[27]==0 || lst_to[28]==0 || lst_to[29]==0 || lst_to[30]==0 || lst_to[31]==0 || lst_to[32]==0 || lst_to[33]==0 || lst_to[34]==0 || lst_to[35]==0 || lst_to[36]==0 || lst_to[37]==0 || lst_to[38]==0 || lst_to[39]==0 ){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}

        	if(myIofDeliveryDate == 35){
        		if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 || lst_to[5]==0 || lst_to[6]==0 || lst_to[7]==0 || lst_to[8]==0 || lst_to[9]==0 || lst_to[10]==0 || lst_to[11]==0 || lst_to[12]==0 || lst_to[13]==0 || lst_to[14]==0 || lst_to[15]==0 || lst_to[16]==0 || lst_to[17]==0 || lst_to[18]==0 || lst_to[19]==0 || lst_to[20]==0 || lst_to[21]==0 || lst_to[22]==0 || lst_to[23]==0 || lst_to[24]==0 || lst_to[25]==0 || lst_to[26]==0 || lst_to[27]==0 || lst_to[28]==0 || lst_to[29]==0 || lst_to[30]==0 || lst_to[31]==0 || lst_to[32]==0 || lst_to[33]==0 || lst_to[34]==0 ){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}

        	if(myIofDeliveryDate == 30){
        		if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 || lst_to[5]==0 || lst_to[6]==0 || lst_to[7]==0 || lst_to[8]==0 || lst_to[9]==0 || lst_to[10]==0 || lst_to[11]==0 || lst_to[12]==0 || lst_to[13]==0 || lst_to[14]==0 || lst_to[15]==0 || lst_to[16]==0 || lst_to[17]==0 || lst_to[18]==0 || lst_to[19]==0 || lst_to[20]==0 || lst_to[21]==0 || lst_to[22]==0 || lst_to[23]==0 || lst_to[24]==0 || lst_to[25]==0 || lst_to[26]==0 || lst_to[27]==0 || lst_to[28]==0 || lst_to[29]==0 ){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}
        	if(myIofDeliveryDate == 25){
        		if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 || lst_to[5]==0 || lst_to[6]==0 || lst_to[7]==0 || lst_to[8]==0 || lst_to[9]==0 || lst_to[10]==0 || lst_to[11]==0 || lst_to[12]==0 || lst_to[13]==0 || lst_to[14]==0 || lst_to[15]==0 || lst_to[16]==0 || lst_to[17]==0 || lst_to[18]==0 || lst_to[19]==0 || lst_to[20]==0 || lst_to[21]==0 || lst_to[22]==0 || lst_to[23]==0 || lst_to[24]==0 ){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}

        	if(myIofDeliveryDate == 20){
        		if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 || lst_to[5]==0 || lst_to[6]==0 || lst_to[7]==0 || lst_to[8]==0 || lst_to[9]==0 || lst_to[10]==0 || lst_to[11]==0 || lst_to[12]==0 || lst_to[13]==0 || lst_to[14]==0 || lst_to[15]==0 || lst_to[16]==0 || lst_to[17]==0 || lst_to[18]==0 || lst_to[19]==0 ){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}
        	
        	if(myIofDeliveryDate == 15){
        		if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 || lst_to[5]==0 || lst_to[6]==0 || lst_to[7]==0 || lst_to[8]==0 || lst_to[9]==0 || lst_to[10]==0 || lst_to[11]==0 || lst_to[12]==0 || lst_to[13]==0 || lst_to[14]==0 ){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}
        	if(myIofDeliveryDate == 10){
        		if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 || lst_to[5]==0 || lst_to[6]==0 || lst_to[7]==0 || lst_to[8]==0 || lst_to[9]==0 ){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}
        	if (myIofDeliveryDate == 5){
			    if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 ){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}

        }else{
           jQuery('.'+myCartBoxKey).html('<span class="text-danger">Sorry, you can only have a maximum of 5 delivery dates for all combined products.</span>');
        }

        
    });

    body.on("click", ".iof-btn-delivery-remove", function () {
        removeDeliveryRow( jQuery(this));
        adjustCartSubtotal();
        jQuery("input[name='update_cart']").removeAttr("disabled");
        setTimeout(function () {
            jQuery('input[name=update_cart]').click();
        }, 800);
    });

    body.on("click",'.checkout-button',function(){
    	var shipping_val = jQuery("input:radio[name=shipping_method\\[0\\]]:checked").val();
	    var shipping_arr = (typeof(shipping_val) != "undefined" && shipping_val !== null) ? shipping_val : 'local_pickup:24';
	    var arr = shipping_arr.split(':');
	    var shipping_method = arr[0];

	    var lst_to = [];
	    jQuery("input:text.iof-delivery-date").each(function() {
	    	if($(this).val() == ''){ lst_to.push(0); }else{ lst_to.push(1);	 }
	    });

        var added=false;
        $.map(lst_to, function(elementOfArray, indexInArray) {
            if (elementOfArray == 0) {
                added = true;
             }
        });
    
	    if(shipping_method){
	    	var checkzipcode = jQuery('#calc_shipping_postcode').val();

		    	if(checkzipcode == ""){
		    		jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please enter shipping zipcode!</li></ul>');
    				 jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
		    		jQuery('#calc_shipping_postcode').focus();
		    		return false;
		    	}else if(added ){
		    		jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
    				 jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
		    		jQuery("input:text:visible:first").focus();
					return false;
		    	}else{
	    			jQuery("input[name='update_cart']").removeAttr("disabled");
                    jQuery('input[name=update_cart]').click();
					return true;
		    	}
	    }
 	
    
    });

    /**
     * Adjust the subtotal in the cart.
     */
    function adjustCartSubtotal() {
        var subtotal = 0;
        var cart_subtotal_obj = jQuery("#iof-cart-subtotal").find(".amount");
        var order_items_obj = jQuery(".iof-item-subtotal");
        order_items_obj.each(function (index, element) {
            subtotal += parseFloat(jQuery(element).val());
        });
        cart_subtotal_obj.html("<span class='woocommerce-Price-currencySymbol'>$</span>" + subtotal.toFixed(2));
    }

    /**
     * Add one delivery row per item quantity.
     *
     * @param button
     * @param num
     */
   function addDeliveryRow(button, num, btnprodid,btnprodname) {
    	selected_dates = get_selected_dates();
    
    		  jQuery.post(
		            ajax_object.ajax_url,
		            {
		                "action": "get_all_disabled_dates",
		                "selected_dates": selected_dates
		            }
		        )
		            .done(function (data) {
						
		                if (!data.max_date_msg) {
		                    var order_item_num = button.children(".iof-order-item").val();
		                    var delivery_row = button.parent().parent().prev();
		                    var delivery_row_new = delivery_row.clone(true, true);
		                    var delivery_row_label_new = delivery_row_new.find(".iof-lbl-delivery-row");
		                    var delivery_calendar_name = delivery_row_new.find(".iof-delivery-date").attr("name");
		                    var delivery_calendar_new = jQuery('<div class="input-group date iof-datepicker"><input type="text"  data-prodId="'+btnprodid+'" data-prodName="'+btnprodname+'"  class="form-control iof-delivery-date"/><span class="input-group-addon"><span class="fa fa-calendar"></span></span></div>');

		                    delivery_row_label_new.removeClass("col-md-offset-4 col-lg-offset-3");
		                    delivery_row_label_new.children("strong").html("Delivery " + num);
		                    delivery_row_new.find(".iof-btn-delivery-remove").parent().removeClass("hidden");
		                    delivery_row_new.find(".iof-delivery-row-num").val(num);
		                    delivery_row_new.find(".iof-datepicker").remove();
		                    delivery_row_new.find(".form-group").html(delivery_calendar_new);
		                    delivery_calendar_new.find('.iof-delivery-date').attr("name", delivery_calendar_name);
		                    delivery_row_new.find(".iof-datepicker").attr("id", "datepicker-" + order_item_num + "-" + num);
		                    var date = data.available_dates[order_item_num];
		                    delivery_row_new.find(".iof-datepicker").datetimepicker({
		                        format: 'dddd, MMM Do YYYY',
		                        allowInputToggle: true,
		                        useCurrent: false,
		                        disabledDates: data.disabled_dates,
		                        minDate: data.available_dates[order_item_num],
		                        daysOfWeekDisabled: data.disabled_week_days,
		                        maxDate: data.max_date,
		                        ignoreReadonly: true
		                    });
		                    delivery_row.after(delivery_row_new);
							 
		                } else {
							 
		                    alert(data.max_date_msg);
		                }
		            })
		            .fail(function (data) {
		                alert('Failed to load calendar.');
		            });
    	
           
    }
	
    function addDeliveryRow1(button, num) {
        selected_dates = get_selected_dates();

        jQuery.post(
            ajax_object.ajax_url,
            {
                "action": "get_all_disabled_dates",
                "selected_dates": selected_dates
            }
        )
            .done(function (data) {
				
                if (!data.max_date_msg) {
                    var order_item_num = button.children(".iof-order-item").val();
                    var delivery_row = button.parent().parent().prev();
                    var delivery_row_new = delivery_row.clone(true, true);
                    var delivery_row_label_new = delivery_row_new.find(".iof-lbl-delivery-row");
                    var delivery_calendar_name = delivery_row_new.find(".iof-delivery-date").attr("name");
                    var delivery_calendar_new = jQuery('<div class="input-group date iof-datepicker"><input type="text" class="form-control iof-delivery-date"/><span class="input-group-addon"><span class="fa fa-calendar"></span></span></div>');

                    delivery_row_label_new.removeClass("col-md-offset-4 col-lg-offset-3");
                    delivery_row_label_new.children("strong").html("Delivery " + num);
                    delivery_row_new.find(".iof-btn-delivery-remove").parent().removeClass("hidden");
                    delivery_row_new.find(".iof-delivery-row-num").val(num);
                    delivery_row_new.find(".iof-datepicker").remove();
                    delivery_row_new.find(".form-group").html(delivery_calendar_new);
                    delivery_calendar_new.find('.iof-delivery-date').attr("name", delivery_calendar_name);
                    delivery_row_new.find(".iof-datepicker").attr("id", "datepicker-" + order_item_num + "-" + num);
                    var date = data.available_dates[order_item_num];
                    delivery_row_new.find(".iof-datepicker").datetimepicker({
                        format: 'dddd, MMM Do YYYY',
                        allowInputToggle: true,
                        useCurrent: false,
                        defaultDate: data.min_date,
                        disabledDates: data.disabled_dates,
                        minDate: data.min_date,
                        daysOfWeekDisabled: data.disabled_week_days,
                        maxDate: data.max_date,
                        ignoreReadonly: true
                    });
                    delivery_row.after(delivery_row_new);
					      var subtotal = 0;
				var cart_subtotal_obj = jQuery("#iof-cart-subtotal").find(".amount");
				var order_items_obj = jQuery(".iof-item-subtotal");
				order_items_obj.each(function (index, element) {
					subtotal += parseFloat(jQuery(element).val());
				});
				cart_subtotal_obj.html("<span class='woocommerce-Price-currencySymbol'>$</span>" + subtotal.toFixed(2));
				jQuery("input[name='update_cart']").removeAttr("disabled"); 
				jQuery('input[name=update_cart]').trigger('click');
                } else {
					 
                    alert(data.max_date_msg);
                }
            })
            .fail(function (data) {
                alert('Failed to load calendar.');
            });
    }

    /**
     * Remove a delivery row for an order item.
     *
     * @param button
     */
    function removeDeliveryRow(button) {
        var delivery_row = button.parent().parent();
        var delivery_num = delivery_row.find(".iof-delivery-row-num").val();
        
        if (delivery_row.next().hasClass("iof-row-delivery-date")) {
            var order_item_row = delivery_row.parent();
            var delivery_rows = order_item_row.find(".iof-row-delivery-date");
            for (var i = 0; i < delivery_rows.length; i++) {
                var row = delivery_rows[i];
                var input_hidden = $(row).find(".iof-delivery-row-num");
                var row_num = parseInt(input_hidden.val());
                if (row_num > delivery_num) {
                    var row_num_new = row_num - 1;
                    var row_label = $(row).find(".iof-lbl-delivery-row");
                    var row_calendar = $(row).find(".iof-datepicker");
                    var order_item_num = button.children(".iof-order-item").val();
                    input_hidden.val(row_num_new);
                    row_label.children("strong").html("Delivery " + row_num_new);
                    row_calendar.attr("id", "datepicker-" + order_item_num + "-" + row_num_new);

                }
            }
        }
        

        delivery_row.remove();
    }

    /**
     * Get the dates already selected for delivery.
     *
     * @return  An array of all selected delivery dates.
     */
    function get_selected_dates() {
        var selected_dates = [];
        jQuery(".iof-order-item-row").each(function (index, item_row) {
        	selected_dates[index] = [];
            jQuery(".iof-datepicker").each(function () {
                selected_dates[index].push(jQuery(this).find('input.iof-delivery-date').val());
            });
        });
        return selected_dates;
    }

    /**
     * Get the delivery dates, formatted with cart item keys.
     *
     * TODO: get_selected_dates can probably be refactored into this, but need to check and test all backend logic
     *
     * @return  An array of all selected delivery dates.
     */
   function get_delivery_dates() {
        var delivery_dates = [];
        jQuery("input[name='delivery-dates']").map( function() {
            delivery_dates.push( jQuery(this) );
        });
    }

}
jQuery('.iof-easy-credit-value').on('click', function() {
    var amount = jQuery(this).data('value');
    jQuery('button.active').removeClass('active');
    jQuery(this).addClass('active');
    jQuery('#iof-credit-amount').val('');
    jQuery('input#credit_called').val(amount);
    jQuery('input#credit_called').keyup();
});

jQuery('#iof-credit-amount').on('keyup', function () {
    var amount = jQuery(this).val();
    jQuery('button.active').removeClass('active');
    jQuery('input#credit_called').val(amount);
    jQuery('input#credit_called').keyup();
});jQuery('.iof-easy-credit-value').on('click', function() {
    var amount = jQuery(this).data('value');
    jQuery('button.active').removeClass('active');
    jQuery(this).addClass('active');
    jQuery('#iof-credit-amount').val('');
    jQuery('input#credit_called').val(amount);
    jQuery('input#credit_called').keyup();
});

jQuery('#iof-credit-amount').on('keyup', function () {
    var amount = jQuery(this).val();
    jQuery('button.active').removeClass('active');
    jQuery('input#credit_called').val(amount);
    jQuery('input#credit_called').keyup();
});

var search_closed = true;

jQuery(window).resize(function () {
    if (jQuery("li#wp-admin-bar-iof-search-forms-mobile").css("display") == "none") {
        jQuery("ul#wp-admin-bar-iof-search-forms").show();
    }

    if (jQuery("li#wp-admin-bar-iof-search-forms-mobile").css("display") == "block") {
        jQuery("ul#wp-admin-bar-iof-search-forms").hide();
    }
    search_closed = true;
});

jQuery("li#wp-admin-bar-iof-search-forms-mobile").click(function () {
    if (search_closed) {
        jQuery("ul#wp-admin-bar-iof-search-forms").show();
    } else {
        jQuery("ul#wp-admin-bar-iof-search-forms").hide();
    }
    search_closed = !search_closed;
});

jQuery("#btn-side").click( function() {
    var side_title = jQuery(".sides_radio_buttons input:checked").val();
    var side_id    = jQuery(".sides_radio_buttons input:checked").next("input[name='side-id-choice']").val();
    var side_img =  jQuery('.iofSideImage-'+side_id+' img').attr('src');

    jQuery("input.side-value").val(side_title);
    jQuery("input[name='side-id']").val(side_id);
    jQuery(".side-title").html(side_title);
    jQuery('#sidesImage img').attr('src',side_img);

});

jQuery("#btn-vegetable").click(function () {
    var vegetable_title = jQuery(".vegetables_radio_buttons input:checked").val();
    var vegetable_id    = jQuery(".vegetables_radio_buttons input:checked").next("input[name='vegetable-id-choice']").val();
    var vegetable_img =  jQuery('.iofVegetablesImage-'+vegetable_id+' img').attr('src');


    jQuery("input.vegetable-value").val(vegetable_title);
    jQuery("input[name='vegetable-id']").val(vegetable_id);
    jQuery(".vegetable-title").html(vegetable_title);
      jQuery('#VegetableImage img').attr('src',vegetable_img);
});

jQuery("#btn-salad").click(function () {
	var salad_title = jQuery(".salads_radio_buttons input:checked").val();
    var salad_id    = jQuery(".salads_radio_buttons input:checked").next("input[name='salad-id-choice']").val();
     var salad_img =  jQuery('.iofSaladImage-'+salad_id+' img').attr('src');

    jQuery("input.salad-value").val(salad_title);
    jQuery("input[name='salad-id']").val(salad_id);
    jQuery(".salad-title").html(salad_title);
          jQuery('#SaladImage img').attr('src',salad_img);

    
});

jQuery("#btn-bread").click(function () {
    var bread_title = jQuery(".breads_radio_buttons input:checked").val();
    var bread_id    = jQuery(".breads_radio_buttons input:checked").next("input[name='bread-id-choice']").val();
    var bread_img =  jQuery('.iofBreadImage-'+bread_id+' img').attr('src');
    jQuery("input.bread-value").val(bread_title);
    jQuery("input[name='bread-id']").val(bread_id);
    jQuery(".bread-title").html(bread_title);
     jQuery('#BreadImage img').attr('src',bread_img);
});

jQuery("#btn-dessert").click(function () {
    var dessert_title = jQuery(".desserts_radio_buttons input:checked").val();
    var dessert_id    = jQuery(".desserts_radio_buttons input:checked").next("input[name='dessert-id-choice']").val();
    var dessert_img =  jQuery('.iofDessertImage-'+dessert_id+' img').attr('src');

     
    jQuery("input.dessert-value").val(dessert_title);
    jQuery("input[name='dessert-id']").val(dessert_id);
    jQuery(".dessert-title").html(dessert_title);
         jQuery('#DessertImage img').attr('src',dessert_img);

});

jQuery(".thumbnail").on('click', function() {
    if(! jQuery(this).hasClass('item-selected') ) {
        var old_selected = jQuery(this).closest(".modal-body").find(".item-selected");
        old_selected.find('label').html('');
        old_selected.find('input[type=radio]').attr('checked', false);
        old_selected.removeClass('item-selected');
        jQuery(this).addClass('item-selected');
        jQuery(this).find('input[type=radio]').attr('checked', true);
        jQuery(this).find('label').html('<i class="fa fa-check" style="left: -15px;position: absolute;top: 4px; color: #86BD3D;"></i>');
    }
});



jQuery('.item-selected').find('input[type=radio]:first').attr('checked', true);//! moment.js
//! version : 2.19.1
//! authors : Tim Wood, Iskren Chernev, Moment.js contributors
//! license : MIT
//! momentjs.com

;(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
    typeof define === 'function' && define.amd ? define(factory) :
    global.moment = factory()
}(this, (function () { 'use strict';

var hookCallback;

function hooks () {
    return hookCallback.apply(null, arguments);
}

// This is done to register the method called with moment()
// without creating circular dependencies.
function setHookCallback (callback) {
    hookCallback = callback;
}

function isArray(input) {
    return input instanceof Array || Object.prototype.toString.call(input) === '[object Array]';
}

function isObject(input) {
    // IE8 will treat undefined and null as object if it wasn't for
    // input != null
    return input != null && Object.prototype.toString.call(input) === '[object Object]';
}

function isObjectEmpty(obj) {
    if (Object.getOwnPropertyNames) {
        return (Object.getOwnPropertyNames(obj).length === 0);
    } else {
        var k;
        for (k in obj) {
            if (obj.hasOwnProperty(k)) {
                return false;
            }
        }
        return true;
    }
}

function isUndefined(input) {
    return input === void 0;
}

function isNumber(input) {
    return typeof input === 'number' || Object.prototype.toString.call(input) === '[object Number]';
}

function isDate(input) {
    return input instanceof Date || Object.prototype.toString.call(input) === '[object Date]';
}

function map(arr, fn) {
    var res = [], i;
    for (i = 0; i < arr.length; ++i) {
        res.push(fn(arr[i], i));
    }
    return res;
}

function hasOwnProp(a, b) {
    return Object.prototype.hasOwnProperty.call(a, b);
}

function extend(a, b) {
    for (var i in b) {
        if (hasOwnProp(b, i)) {
            a[i] = b[i];
        }
    }

    if (hasOwnProp(b, 'toString')) {
        a.toString = b.toString;
    }

    if (hasOwnProp(b, 'valueOf')) {
        a.valueOf = b.valueOf;
    }

    return a;
}

function createUTC (input, format, locale, strict) {
    return createLocalOrUTC(input, format, locale, strict, true).utc();
}

function defaultParsingFlags() {
    // We need to deep clone this object.
    return {
        empty           : false,
        unusedTokens    : [],
        unusedInput     : [],
        overflow        : -2,
        charsLeftOver   : 0,
        nullInput       : false,
        invalidMonth    : null,
        invalidFormat   : false,
        userInvalidated : false,
        iso             : false,
        parsedDateParts : [],
        meridiem        : null,
        rfc2822         : false,
        weekdayMismatch : false
    };
}

function getParsingFlags(m) {
    if (m._pf == null) {
        m._pf = defaultParsingFlags();
    }
    return m._pf;
}

var some;
if (Array.prototype.some) {
    some = Array.prototype.some;
} else {
    some = function (fun) {
        var t = Object(this);
        var len = t.length >>> 0;

        for (var i = 0; i < len; i++) {
            if (i in t && fun.call(this, t[i], i, t)) {
                return true;
            }
        }

        return false;
    };
}

function isValid(m) {
    if (m._isValid == null) {
        var flags = getParsingFlags(m);
        var parsedParts = some.call(flags.parsedDateParts, function (i) {
            return i != null;
        });
        var isNowValid = !isNaN(m._d.getTime()) &&
            flags.overflow < 0 &&
            !flags.empty &&
            !flags.invalidMonth &&
            !flags.invalidWeekday &&
            !flags.weekdayMismatch &&
            !flags.nullInput &&
            !flags.invalidFormat &&
            !flags.userInvalidated &&
            (!flags.meridiem || (flags.meridiem && parsedParts));

        if (m._strict) {
            isNowValid = isNowValid &&
                flags.charsLeftOver === 0 &&
                flags.unusedTokens.length === 0 &&
                flags.bigHour === undefined;
        }

        if (Object.isFrozen == null || !Object.isFrozen(m)) {
            m._isValid = isNowValid;
        }
        else {
            return isNowValid;
        }
    }
    return m._isValid;
}

function createInvalid (flags) {
    var m = createUTC(NaN);
    if (flags != null) {
        extend(getParsingFlags(m), flags);
    }
    else {
        getParsingFlags(m).userInvalidated = true;
    }

    return m;
}

// Plugins that add properties should also add the key here (null value),
// so we can properly clone ourselves.
var momentProperties = hooks.momentProperties = [];

function copyConfig(to, from) {
    var i, prop, val;

    if (!isUndefined(from._isAMomentObject)) {
        to._isAMomentObject = from._isAMomentObject;
    }
    if (!isUndefined(from._i)) {
        to._i = from._i;
    }
    if (!isUndefined(from._f)) {
        to._f = from._f;
    }
    if (!isUndefined(from._l)) {
        to._l = from._l;
    }
    if (!isUndefined(from._strict)) {
        to._strict = from._strict;
    }
    if (!isUndefined(from._tzm)) {
        to._tzm = from._tzm;
    }
    if (!isUndefined(from._isUTC)) {
        to._isUTC = from._isUTC;
    }
    if (!isUndefined(from._offset)) {
        to._offset = from._offset;
    }
    if (!isUndefined(from._pf)) {
        to._pf = getParsingFlags(from);
    }
    if (!isUndefined(from._locale)) {
        to._locale = from._locale;
    }

    if (momentProperties.length > 0) {
        for (i = 0; i < momentProperties.length; i++) {
            prop = momentProperties[i];
            val = from[prop];
            if (!isUndefined(val)) {
                to[prop] = val;
            }
        }
    }

    return to;
}

var updateInProgress = false;

// Moment prototype object
function Moment(config) {
    copyConfig(this, config);
    this._d = new Date(config._d != null ? config._d.getTime() : NaN);
    if (!this.isValid()) {
        this._d = new Date(NaN);
    }
    // Prevent infinite loop in case updateOffset creates new moment
    // objects.
    if (updateInProgress === false) {
        updateInProgress = true;
        hooks.updateOffset(this);
        updateInProgress = false;
    }
}

function isMoment (obj) {
    return obj instanceof Moment || (obj != null && obj._isAMomentObject != null);
}

function absFloor (number) {
    if (number < 0) {
        // -0 -> 0
        return Math.ceil(number) || 0;
    } else {
        return Math.floor(number);
    }
}

function toInt(argumentForCoercion) {
    var coercedNumber = +argumentForCoercion,
        value = 0;

    if (coercedNumber !== 0 && isFinite(coercedNumber)) {
        value = absFloor(coercedNumber);
    }

    return value;
}

// compare two arrays, return the number of differences
function compareArrays(array1, array2, dontConvert) {
    var len = Math.min(array1.length, array2.length),
        lengthDiff = Math.abs(array1.length - array2.length),
        diffs = 0,
        i;
    for (i = 0; i < len; i++) {
        if ((dontConvert && array1[i] !== array2[i]) ||
            (!dontConvert && toInt(array1[i]) !== toInt(array2[i]))) {
            diffs++;
        }
    }
    return diffs + lengthDiff;
}

function warn(msg) {
    if (hooks.suppressDeprecationWarnings === false &&
            (typeof console !==  'undefined') && console.warn) {
        console.warn('Deprecation warning: ' + msg);
    }
}

function deprecate(msg, fn) {
    var firstTime = true;

    return extend(function () {
        if (hooks.deprecationHandler != null) {
            hooks.deprecationHandler(null, msg);
        }
        if (firstTime) {
            var args = [];
            var arg;
            for (var i = 0; i < arguments.length; i++) {
                arg = '';
                if (typeof arguments[i] === 'object') {
                    arg += '\n[' + i + '] ';
                    for (var key in arguments[0]) {
                        arg += key + ': ' + arguments[0][key] + ', ';
                    }
                    arg = arg.slice(0, -2); // Remove trailing comma and space
                } else {
                    arg = arguments[i];
                }
                args.push(arg);
            }
            warn(msg + '\nArguments: ' + Array.prototype.slice.call(args).join('') + '\n' + (new Error()).stack);
            firstTime = false;
        }
        return fn.apply(this, arguments);
    }, fn);
}

var deprecations = {};

function deprecateSimple(name, msg) {
    if (hooks.deprecationHandler != null) {
        hooks.deprecationHandler(name, msg);
    }
    if (!deprecations[name]) {
        warn(msg);
        deprecations[name] = true;
    }
}

hooks.suppressDeprecationWarnings = false;
hooks.deprecationHandler = null;

function isFunction(input) {
    return input instanceof Function || Object.prototype.toString.call(input) === '[object Function]';
}

function set (config) {
    var prop, i;
    for (i in config) {
        prop = config[i];
        if (isFunction(prop)) {
            this[i] = prop;
        } else {
            this['_' + i] = prop;
        }
    }
    this._config = config;
    // Lenient ordinal parsing accepts just a number in addition to
    // number + (possibly) stuff coming from _dayOfMonthOrdinalParse.
    // TODO: Remove "ordinalParse" fallback in next major release.
    this._dayOfMonthOrdinalParseLenient = new RegExp(
        (this._dayOfMonthOrdinalParse.source || this._ordinalParse.source) +
            '|' + (/\d{1,2}/).source);
}

function mergeConfigs(parentConfig, childConfig) {
    var res = extend({}, parentConfig), prop;
    for (prop in childConfig) {
        if (hasOwnProp(childConfig, prop)) {
            if (isObject(parentConfig[prop]) && isObject(childConfig[prop])) {
                res[prop] = {};
                extend(res[prop], parentConfig[prop]);
                extend(res[prop], childConfig[prop]);
            } else if (childConfig[prop] != null) {
                res[prop] = childConfig[prop];
            } else {
                delete res[prop];
            }
        }
    }
    for (prop in parentConfig) {
        if (hasOwnProp(parentConfig, prop) &&
                !hasOwnProp(childConfig, prop) &&
                isObject(parentConfig[prop])) {
            // make sure changes to properties don't modify parent config
            res[prop] = extend({}, res[prop]);
        }
    }
    return res;
}

function Locale(config) {
    if (config != null) {
        this.set(config);
    }
}

var keys;

if (Object.keys) {
    keys = Object.keys;
} else {
    keys = function (obj) {
        var i, res = [];
        for (i in obj) {
            if (hasOwnProp(obj, i)) {
                res.push(i);
            }
        }
        return res;
    };
}

var defaultCalendar = {
    sameDay : '[Today at] LT',
    nextDay : '[Tomorrow at] LT',
    nextWeek : 'dddd [at] LT',
    lastDay : '[Yesterday at] LT',
    lastWeek : '[Last] dddd [at] LT',
    sameElse : 'L'
};

function calendar (key, mom, now) {
    var output = this._calendar[key] || this._calendar['sameElse'];
    return isFunction(output) ? output.call(mom, now) : output;
}

var defaultLongDateFormat = {
    LTS  : 'h:mm:ss A',
    LT   : 'h:mm A',
    L    : 'MM/DD/YYYY',
    LL   : 'MMMM D, YYYY',
    LLL  : 'MMMM D, YYYY h:mm A',
    LLLL : 'dddd, MMMM D, YYYY h:mm A'
};

function longDateFormat (key) {
    var format = this._longDateFormat[key],
        formatUpper = this._longDateFormat[key.toUpperCase()];

    if (format || !formatUpper) {
        return format;
    }

    this._longDateFormat[key] = formatUpper.replace(/MMMM|MM|DD|dddd/g, function (val) {
        return val.slice(1);
    });

    return this._longDateFormat[key];
}

var defaultInvalidDate = 'Invalid date';

function invalidDate () {
    return this._invalidDate;
}

var defaultOrdinal = '%d';
var defaultDayOfMonthOrdinalParse = /\d{1,2}/;

function ordinal (number) {
    return this._ordinal.replace('%d', number);
}

var defaultRelativeTime = {
    future : 'in %s',
    past   : '%s ago',
    s  : 'a few seconds',
    ss : '%d seconds',
    m  : 'a minute',
    mm : '%d minutes',
    h  : 'an hour',
    hh : '%d hours',
    d  : 'a day',
    dd : '%d days',
    M  : 'a month',
    MM : '%d months',
    y  : 'a year',
    yy : '%d years'
};

function relativeTime (number, withoutSuffix, string, isFuture) {
    var output = this._relativeTime[string];
    return (isFunction(output)) ?
        output(number, withoutSuffix, string, isFuture) :
        output.replace(/%d/i, number);
}

function pastFuture (diff, output) {
    var format = this._relativeTime[diff > 0 ? 'future' : 'past'];
    return isFunction(format) ? format(output) : format.replace(/%s/i, output);
}

var aliases = {};

function addUnitAlias (unit, shorthand) {
    var lowerCase = unit.toLowerCase();
    aliases[lowerCase] = aliases[lowerCase + 's'] = aliases[shorthand] = unit;
}

function normalizeUnits(units) {
    return typeof units === 'string' ? aliases[units] || aliases[units.toLowerCase()] : undefined;
}

function normalizeObjectUnits(inputObject) {
    var normalizedInput = {},
        normalizedProp,
        prop;

    for (prop in inputObject) {
        if (hasOwnProp(inputObject, prop)) {
            normalizedProp = normalizeUnits(prop);
            if (normalizedProp) {
                normalizedInput[normalizedProp] = inputObject[prop];
            }
        }
    }

    return normalizedInput;
}

var priorities = {};

function addUnitPriority(unit, priority) {
    priorities[unit] = priority;
}

function getPrioritizedUnits(unitsObj) {
    var units = [];
    for (var u in unitsObj) {
        units.push({unit: u, priority: priorities[u]});
    }
    units.sort(function (a, b) {
        return a.priority - b.priority;
    });
    return units;
}

function zeroFill(number, targetLength, forceSign) {
    var absNumber = '' + Math.abs(number),
        zerosToFill = targetLength - absNumber.length,
        sign = number >= 0;
    return (sign ? (forceSign ? '+' : '') : '-') +
        Math.pow(10, Math.max(0, zerosToFill)).toString().substr(1) + absNumber;
}

var formattingTokens = /(\[[^\[]*\])|(\\)?([Hh]mm(ss)?|Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|Qo?|YYYYYY|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|kk?|mm?|ss?|S{1,9}|x|X|zz?|ZZ?|.)/g;

var localFormattingTokens = /(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g;

var formatFunctions = {};

var formatTokenFunctions = {};

// token:    'M'
// padded:   ['MM', 2]
// ordinal:  'Mo'
// callback: function () { this.month() + 1 }
function addFormatToken (token, padded, ordinal, callback) {
    var func = callback;
    if (typeof callback === 'string') {
        func = function () {
            return this[callback]();
        };
    }
    if (token) {
        formatTokenFunctions[token] = func;
    }
    if (padded) {
        formatTokenFunctions[padded[0]] = function () {
            return zeroFill(func.apply(this, arguments), padded[1], padded[2]);
        };
    }
    if (ordinal) {
        formatTokenFunctions[ordinal] = function () {
            return this.localeData().ordinal(func.apply(this, arguments), token);
        };
    }
}

function removeFormattingTokens(input) {
    if (input.match(/\[[\s\S]/)) {
        return input.replace(/^\[|\]$/g, '');
    }
    return input.replace(/\\/g, '');
}

function makeFormatFunction(format) {
    var array = format.match(formattingTokens), i, length;

    for (i = 0, length = array.length; i < length; i++) {
        if (formatTokenFunctions[array[i]]) {
            array[i] = formatTokenFunctions[array[i]];
        } else {
            array[i] = removeFormattingTokens(array[i]);
        }
    }

    return function (mom) {
        var output = '', i;
        for (i = 0; i < length; i++) {
            output += isFunction(array[i]) ? array[i].call(mom, format) : array[i];
        }
        return output;
    };
}

// format date using native date object
function formatMoment(m, format) {
    if (!m.isValid()) {
        return m.localeData().invalidDate();
    }

    format = expandFormat(format, m.localeData());
    formatFunctions[format] = formatFunctions[format] || makeFormatFunction(format);

    return formatFunctions[format](m);
}

function expandFormat(format, locale) {
    var i = 5;

    function replaceLongDateFormatTokens(input) {
        return locale.longDateFormat(input) || input;
    }

    localFormattingTokens.lastIndex = 0;
    while (i >= 0 && localFormattingTokens.test(format)) {
        format = format.replace(localFormattingTokens, replaceLongDateFormatTokens);
        localFormattingTokens.lastIndex = 0;
        i -= 1;
    }

    return format;
}

var match1         = /\d/;            //       0 - 9
var match2         = /\d\d/;          //      00 - 99
var match3         = /\d{3}/;         //     000 - 999
var match4         = /\d{4}/;         //    0000 - 9999
var match6         = /[+-]?\d{6}/;    // -999999 - 999999
var match1to2      = /\d\d?/;         //       0 - 99
var match3to4      = /\d\d\d\d?/;     //     999 - 9999
var match5to6      = /\d\d\d\d\d\d?/; //   99999 - 999999
var match1to3      = /\d{1,3}/;       //       0 - 999
var match1to4      = /\d{1,4}/;       //       0 - 9999
var match1to6      = /[+-]?\d{1,6}/;  // -999999 - 999999

var matchUnsigned  = /\d+/;           //       0 - inf
var matchSigned    = /[+-]?\d+/;      //    -inf - inf

var matchOffset    = /Z|[+-]\d\d:?\d\d/gi; // +00:00 -00:00 +0000 -0000 or Z
var matchShortOffset = /Z|[+-]\d\d(?::?\d\d)?/gi; // +00 -00 +00:00 -00:00 +0000 -0000 or Z

var matchTimestamp = /[+-]?\d+(\.\d{1,3})?/; // 123456789 123456789.123

// any word (or two) characters or numbers including two/three word month in arabic.
// includes scottish gaelic two word and hyphenated months
var matchWord = /[0-9]*['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+|[\u0600-\u06FF\/]+(\s*?[\u0600-\u06FF]+){1,2}/i;


var regexes = {};

function addRegexToken (token, regex, strictRegex) {
    regexes[token] = isFunction(regex) ? regex : function (isStrict, localeData) {
        return (isStrict && strictRegex) ? strictRegex : regex;
    };
}

function getParseRegexForToken (token, config) {
    if (!hasOwnProp(regexes, token)) {
        return new RegExp(unescapeFormat(token));
    }

    return regexes[token](config._strict, config._locale);
}

// Code from http://stackoverflow.com/questions/3561493/is-there-a-regexp-escape-function-in-javascript
function unescapeFormat(s) {
    return regexEscape(s.replace('\\', '').replace(/\\(\[)|\\(\])|\[([^\]\[]*)\]|\\(.)/g, function (matched, p1, p2, p3, p4) {
        return p1 || p2 || p3 || p4;
    }));
}

function regexEscape(s) {
    return s.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
}

var tokens = {};

function addParseToken (token, callback) {
    var i, func = callback;
    if (typeof token === 'string') {
        token = [token];
    }
    if (isNumber(callback)) {
        func = function (input, array) {
            array[callback] = toInt(input);
        };
    }
    for (i = 0; i < token.length; i++) {
        tokens[token[i]] = func;
    }
}

function addWeekParseToken (token, callback) {
    addParseToken(token, function (input, array, config, token) {
        config._w = config._w || {};
        callback(input, config._w, config, token);
    });
}

function addTimeToArrayFromToken(token, input, config) {
    if (input != null && hasOwnProp(tokens, token)) {
        tokens[token](input, config._a, config, token);
    }
}

var YEAR = 0;
var MONTH = 1;
var DATE = 2;
var HOUR = 3;
var MINUTE = 4;
var SECOND = 5;
var MILLISECOND = 6;
var WEEK = 7;
var WEEKDAY = 8;

// FORMATTING

addFormatToken('Y', 0, 0, function () {
    var y = this.year();
    return y <= 9999 ? '' + y : '+' + y;
});

addFormatToken(0, ['YY', 2], 0, function () {
    return this.year() % 100;
});

addFormatToken(0, ['YYYY',   4],       0, 'year');
addFormatToken(0, ['YYYYY',  5],       0, 'year');
addFormatToken(0, ['YYYYYY', 6, true], 0, 'year');

// ALIASES

addUnitAlias('year', 'y');

// PRIORITIES

addUnitPriority('year', 1);

// PARSING

addRegexToken('Y',      matchSigned);
addRegexToken('YY',     match1to2, match2);
addRegexToken('YYYY',   match1to4, match4);
addRegexToken('YYYYY',  match1to6, match6);
addRegexToken('YYYYYY', match1to6, match6);

addParseToken(['YYYYY', 'YYYYYY'], YEAR);
addParseToken('YYYY', function (input, array) {
    array[YEAR] = input.length === 2 ? hooks.parseTwoDigitYear(input) : toInt(input);
});
addParseToken('YY', function (input, array) {
    array[YEAR] = hooks.parseTwoDigitYear(input);
});
addParseToken('Y', function (input, array) {
    array[YEAR] = parseInt(input, 10);
});

// HELPERS

function daysInYear(year) {
    return isLeapYear(year) ? 366 : 365;
}

function isLeapYear(year) {
    return (year % 4 === 0 && year % 100 !== 0) || year % 400 === 0;
}

// HOOKS

hooks.parseTwoDigitYear = function (input) {
    return toInt(input) + (toInt(input) > 68 ? 1900 : 2000);
};

// MOMENTS

var getSetYear = makeGetSet('FullYear', true);

function getIsLeapYear () {
    return isLeapYear(this.year());
}

function makeGetSet (unit, keepTime) {
    return function (value) {
        if (value != null) {
            set$1(this, unit, value);
            hooks.updateOffset(this, keepTime);
            return this;
        } else {
            return get(this, unit);
        }
    };
}

function get (mom, unit) {
    return mom.isValid() ?
        mom._d['get' + (mom._isUTC ? 'UTC' : '') + unit]() : NaN;
}

function set$1 (mom, unit, value) {
    if (mom.isValid() && !isNaN(value)) {
        if (unit === 'FullYear' && isLeapYear(mom.year())) {
            mom._d['set' + (mom._isUTC ? 'UTC' : '') + unit](value, mom.month(), daysInMonth(value, mom.month()));
        }
        else {
            mom._d['set' + (mom._isUTC ? 'UTC' : '') + unit](value);
        }
    }
}

// MOMENTS

function stringGet (units) {
    units = normalizeUnits(units);
    if (isFunction(this[units])) {
        return this[units]();
    }
    return this;
}


function stringSet (units, value) {
    if (typeof units === 'object') {
        units = normalizeObjectUnits(units);
        var prioritized = getPrioritizedUnits(units);
        for (var i = 0; i < prioritized.length; i++) {
            this[prioritized[i].unit](units[prioritized[i].unit]);
        }
    } else {
        units = normalizeUnits(units);
        if (isFunction(this[units])) {
            return this[units](value);
        }
    }
    return this;
}

function mod(n, x) {
    return ((n % x) + x) % x;
}

var indexOf;

if (Array.prototype.indexOf) {
    indexOf = Array.prototype.indexOf;
} else {
    indexOf = function (o) {
        // I know
        var i;
        for (i = 0; i < this.length; ++i) {
            if (this[i] === o) {
                return i;
            }
        }
        return -1;
    };
}

function daysInMonth(year, month) {
    if (isNaN(year) || isNaN(month)) {
        return NaN;
    }
    var modMonth = mod(month, 12);
    year += (month - modMonth) / 12;
    return modMonth === 1 ? (isLeapYear(year) ? 29 : 28) : (31 - modMonth % 7 % 2);
}

// FORMATTING

addFormatToken('M', ['MM', 2], 'Mo', function () {
    return this.month() + 1;
});

addFormatToken('MMM', 0, 0, function (format) {
    return this.localeData().monthsShort(this, format);
});

addFormatToken('MMMM', 0, 0, function (format) {
    return this.localeData().months(this, format);
});

// ALIASES

addUnitAlias('month', 'M');

// PRIORITY

addUnitPriority('month', 8);

// PARSING

addRegexToken('M',    match1to2);
addRegexToken('MM',   match1to2, match2);
addRegexToken('MMM',  function (isStrict, locale) {
    return locale.monthsShortRegex(isStrict);
});
addRegexToken('MMMM', function (isStrict, locale) {
    return locale.monthsRegex(isStrict);
});

addParseToken(['M', 'MM'], function (input, array) {
    array[MONTH] = toInt(input) - 1;
});

addParseToken(['MMM', 'MMMM'], function (input, array, config, token) {
    var month = config._locale.monthsParse(input, token, config._strict);
    // if we didn't find a month name, mark the date as invalid.
    if (month != null) {
        array[MONTH] = month;
    } else {
        getParsingFlags(config).invalidMonth = input;
    }
});

// LOCALES

var MONTHS_IN_FORMAT = /D[oD]?(\[[^\[\]]*\]|\s)+MMMM?/;
var defaultLocaleMonths = 'January_February_March_April_May_June_July_August_September_October_November_December'.split('_');
function localeMonths (m, format) {
    if (!m) {
        return isArray(this._months) ? this._months :
            this._months['standalone'];
    }
    return isArray(this._months) ? this._months[m.month()] :
        this._months[(this._months.isFormat || MONTHS_IN_FORMAT).test(format) ? 'format' : 'standalone'][m.month()];
}

var defaultLocaleMonthsShort = 'Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec'.split('_');
function localeMonthsShort (m, format) {
    if (!m) {
        return isArray(this._monthsShort) ? this._monthsShort :
            this._monthsShort['standalone'];
    }
    return isArray(this._monthsShort) ? this._monthsShort[m.month()] :
        this._monthsShort[MONTHS_IN_FORMAT.test(format) ? 'format' : 'standalone'][m.month()];
}

function handleStrictParse(monthName, format, strict) {
    var i, ii, mom, llc = monthName.toLocaleLowerCase();
    if (!this._monthsParse) {
        // this is not used
        this._monthsParse = [];
        this._longMonthsParse = [];
        this._shortMonthsParse = [];
        for (i = 0; i < 12; ++i) {
            mom = createUTC([2000, i]);
            this._shortMonthsParse[i] = this.monthsShort(mom, '').toLocaleLowerCase();
            this._longMonthsParse[i] = this.months(mom, '').toLocaleLowerCase();
        }
    }

    if (strict) {
        if (format === 'MMM') {
            ii = indexOf.call(this._shortMonthsParse, llc);
            return ii !== -1 ? ii : null;
        } else {
            ii = indexOf.call(this._longMonthsParse, llc);
            return ii !== -1 ? ii : null;
        }
    } else {
        if (format === 'MMM') {
            ii = indexOf.call(this._shortMonthsParse, llc);
            if (ii !== -1) {
                return ii;
            }
            ii = indexOf.call(this._longMonthsParse, llc);
            return ii !== -1 ? ii : null;
        } else {
            ii = indexOf.call(this._longMonthsParse, llc);
            if (ii !== -1) {
                return ii;
            }
            ii = indexOf.call(this._shortMonthsParse, llc);
            return ii !== -1 ? ii : null;
        }
    }
}

function localeMonthsParse (monthName, format, strict) {
    var i, mom, regex;

    if (this._monthsParseExact) {
        return handleStrictParse.call(this, monthName, format, strict);
    }

    if (!this._monthsParse) {
        this._monthsParse = [];
        this._longMonthsParse = [];
        this._shortMonthsParse = [];
    }

    // TODO: add sorting
    // Sorting makes sure if one month (or abbr) is a prefix of another
    // see sorting in computeMonthsParse
    for (i = 0; i < 12; i++) {
        // make the regex if we don't have it already
        mom = createUTC([2000, i]);
        if (strict && !this._longMonthsParse[i]) {
            this._longMonthsParse[i] = new RegExp('^' + this.months(mom, '').replace('.', '') + '$', 'i');
            this._shortMonthsParse[i] = new RegExp('^' + this.monthsShort(mom, '').replace('.', '') + '$', 'i');
        }
        if (!strict && !this._monthsParse[i]) {
            regex = '^' + this.months(mom, '') + '|^' + this.monthsShort(mom, '');
            this._monthsParse[i] = new RegExp(regex.replace('.', ''), 'i');
        }
        // test the regex
        if (strict && format === 'MMMM' && this._longMonthsParse[i].test(monthName)) {
            return i;
        } else if (strict && format === 'MMM' && this._shortMonthsParse[i].test(monthName)) {
            return i;
        } else if (!strict && this._monthsParse[i].test(monthName)) {
            return i;
        }
    }
}

// MOMENTS

function setMonth (mom, value) {
    var dayOfMonth;

    if (!mom.isValid()) {
        // No op
        return mom;
    }

    if (typeof value === 'string') {
        if (/^\d+$/.test(value)) {
            value = toInt(value);
        } else {
            value = mom.localeData().monthsParse(value);
            // TODO: Another silent failure?
            if (!isNumber(value)) {
                return mom;
            }
        }
    }

    dayOfMonth = Math.min(mom.date(), daysInMonth(mom.year(), value));
    mom._d['set' + (mom._isUTC ? 'UTC' : '') + 'Month'](value, dayOfMonth);
    return mom;
}

function getSetMonth (value) {
    if (value != null) {
        setMonth(this, value);
        hooks.updateOffset(this, true);
        return this;
    } else {
        return get(this, 'Month');
    }
}

function getDaysInMonth () {
    return daysInMonth(this.year(), this.month());
}

var defaultMonthsShortRegex = matchWord;
function monthsShortRegex (isStrict) {
    if (this._monthsParseExact) {
        if (!hasOwnProp(this, '_monthsRegex')) {
            computeMonthsParse.call(this);
        }
        if (isStrict) {
            return this._monthsShortStrictRegex;
        } else {
            return this._monthsShortRegex;
        }
    } else {
        if (!hasOwnProp(this, '_monthsShortRegex')) {
            this._monthsShortRegex = defaultMonthsShortRegex;
        }
        return this._monthsShortStrictRegex && isStrict ?
            this._monthsShortStrictRegex : this._monthsShortRegex;
    }
}

var defaultMonthsRegex = matchWord;
function monthsRegex (isStrict) {
    if (this._monthsParseExact) {
        if (!hasOwnProp(this, '_monthsRegex')) {
            computeMonthsParse.call(this);
        }
        if (isStrict) {
            return this._monthsStrictRegex;
        } else {
            return this._monthsRegex;
        }
    } else {
        if (!hasOwnProp(this, '_monthsRegex')) {
            this._monthsRegex = defaultMonthsRegex;
        }
        return this._monthsStrictRegex && isStrict ?
            this._monthsStrictRegex : this._monthsRegex;
    }
}

function computeMonthsParse () {
    function cmpLenRev(a, b) {
        return b.length - a.length;
    }

    var shortPieces = [], longPieces = [], mixedPieces = [],
        i, mom;
    for (i = 0; i < 12; i++) {
        // make the regex if we don't have it already
        mom = createUTC([2000, i]);
        shortPieces.push(this.monthsShort(mom, ''));
        longPieces.push(this.months(mom, ''));
        mixedPieces.push(this.months(mom, ''));
        mixedPieces.push(this.monthsShort(mom, ''));
    }
    // Sorting makes sure if one month (or abbr) is a prefix of another it
    // will match the longer piece.
    shortPieces.sort(cmpLenRev);
    longPieces.sort(cmpLenRev);
    mixedPieces.sort(cmpLenRev);
    for (i = 0; i < 12; i++) {
        shortPieces[i] = regexEscape(shortPieces[i]);
        longPieces[i] = regexEscape(longPieces[i]);
    }
    for (i = 0; i < 24; i++) {
        mixedPieces[i] = regexEscape(mixedPieces[i]);
    }

    this._monthsRegex = new RegExp('^(' + mixedPieces.join('|') + ')', 'i');
    this._monthsShortRegex = this._monthsRegex;
    this._monthsStrictRegex = new RegExp('^(' + longPieces.join('|') + ')', 'i');
    this._monthsShortStrictRegex = new RegExp('^(' + shortPieces.join('|') + ')', 'i');
}

function createDate (y, m, d, h, M, s, ms) {
    // can't just apply() to create a date:
    // https://stackoverflow.com/q/181348
    var date = new Date(y, m, d, h, M, s, ms);

    // the date constructor remaps years 0-99 to 1900-1999
    if (y < 100 && y >= 0 && isFinite(date.getFullYear())) {
        date.setFullYear(y);
    }
    return date;
}

function createUTCDate (y) {
    var date = new Date(Date.UTC.apply(null, arguments));

    // the Date.UTC function remaps years 0-99 to 1900-1999
    if (y < 100 && y >= 0 && isFinite(date.getUTCFullYear())) {
        date.setUTCFullYear(y);
    }
    return date;
}

// start-of-first-week - start-of-year
function firstWeekOffset(year, dow, doy) {
    var // first-week day -- which january is always in the first week (4 for iso, 1 for other)
        fwd = 7 + dow - doy,
        // first-week day local weekday -- which local weekday is fwd
        fwdlw = (7 + createUTCDate(year, 0, fwd).getUTCDay() - dow) % 7;

    return -fwdlw + fwd - 1;
}

// https://en.wikipedia.org/wiki/ISO_week_date#Calculating_a_date_given_the_year.2C_week_number_and_weekday
function dayOfYearFromWeeks(year, week, weekday, dow, doy) {
    var localWeekday = (7 + weekday - dow) % 7,
        weekOffset = firstWeekOffset(year, dow, doy),
        dayOfYear = 1 + 7 * (week - 1) + localWeekday + weekOffset,
        resYear, resDayOfYear;

    if (dayOfYear <= 0) {
        resYear = year - 1;
        resDayOfYear = daysInYear(resYear) + dayOfYear;
    } else if (dayOfYear > daysInYear(year)) {
        resYear = year + 1;
        resDayOfYear = dayOfYear - daysInYear(year);
    } else {
        resYear = year;
        resDayOfYear = dayOfYear;
    }

    return {
        year: resYear,
        dayOfYear: resDayOfYear
    };
}

function weekOfYear(mom, dow, doy) {
    var weekOffset = firstWeekOffset(mom.year(), dow, doy),
        week = Math.floor((mom.dayOfYear() - weekOffset - 1) / 7) + 1,
        resWeek, resYear;

    if (week < 1) {
        resYear = mom.year() - 1;
        resWeek = week + weeksInYear(resYear, dow, doy);
    } else if (week > weeksInYear(mom.year(), dow, doy)) {
        resWeek = week - weeksInYear(mom.year(), dow, doy);
        resYear = mom.year() + 1;
    } else {
        resYear = mom.year();
        resWeek = week;
    }

    return {
        week: resWeek,
        year: resYear
    };
}

function weeksInYear(year, dow, doy) {
    var weekOffset = firstWeekOffset(year, dow, doy),
        weekOffsetNext = firstWeekOffset(year + 1, dow, doy);
    return (daysInYear(year) - weekOffset + weekOffsetNext) / 7;
}

// FORMATTING

addFormatToken('w', ['ww', 2], 'wo', 'week');
addFormatToken('W', ['WW', 2], 'Wo', 'isoWeek');

// ALIASES

addUnitAlias('week', 'w');
addUnitAlias('isoWeek', 'W');

// PRIORITIES

addUnitPriority('week', 5);
addUnitPriority('isoWeek', 5);

// PARSING

addRegexToken('w',  match1to2);
addRegexToken('ww', match1to2, match2);
addRegexToken('W',  match1to2);
addRegexToken('WW', match1to2, match2);

addWeekParseToken(['w', 'ww', 'W', 'WW'], function (input, week, config, token) {
    week[token.substr(0, 1)] = toInt(input);
});

// HELPERS

// LOCALES

function localeWeek (mom) {
    return weekOfYear(mom, this._week.dow, this._week.doy).week;
}

var defaultLocaleWeek = {
    dow : 0, // Sunday is the first day of the week.
    doy : 6  // The week that contains Jan 1st is the first week of the year.
};

function localeFirstDayOfWeek () {
    return this._week.dow;
}

function localeFirstDayOfYear () {
    return this._week.doy;
}

// MOMENTS

function getSetWeek (input) {
    var week = this.localeData().week(this);
    return input == null ? week : this.add((input - week) * 7, 'd');
}

function getSetISOWeek (input) {
    var week = weekOfYear(this, 1, 4).week;
    return input == null ? week : this.add((input - week) * 7, 'd');
}

// FORMATTING

addFormatToken('d', 0, 'do', 'day');

addFormatToken('dd', 0, 0, function (format) {
    return this.localeData().weekdaysMin(this, format);
});

addFormatToken('ddd', 0, 0, function (format) {
    return this.localeData().weekdaysShort(this, format);
});

addFormatToken('dddd', 0, 0, function (format) {
    return this.localeData().weekdays(this, format);
});

addFormatToken('e', 0, 0, 'weekday');
addFormatToken('E', 0, 0, 'isoWeekday');

// ALIASES

addUnitAlias('day', 'd');
addUnitAlias('weekday', 'e');
addUnitAlias('isoWeekday', 'E');

// PRIORITY
addUnitPriority('day', 11);
addUnitPriority('weekday', 11);
addUnitPriority('isoWeekday', 11);

// PARSING

addRegexToken('d',    match1to2);
addRegexToken('e',    match1to2);
addRegexToken('E',    match1to2);
addRegexToken('dd',   function (isStrict, locale) {
    return locale.weekdaysMinRegex(isStrict);
});
addRegexToken('ddd',   function (isStrict, locale) {
    return locale.weekdaysShortRegex(isStrict);
});
addRegexToken('dddd',   function (isStrict, locale) {
    return locale.weekdaysRegex(isStrict);
});

addWeekParseToken(['dd', 'ddd', 'dddd'], function (input, week, config, token) {
    var weekday = config._locale.weekdaysParse(input, token, config._strict);
    // if we didn't get a weekday name, mark the date as invalid
    if (weekday != null) {
        week.d = weekday;
    } else {
        getParsingFlags(config).invalidWeekday = input;
    }
});

addWeekParseToken(['d', 'e', 'E'], function (input, week, config, token) {
    week[token] = toInt(input);
});

// HELPERS

function parseWeekday(input, locale) {
    if (typeof input !== 'string') {
        return input;
    }

    if (!isNaN(input)) {
        return parseInt(input, 10);
    }

    input = locale.weekdaysParse(input);
    if (typeof input === 'number') {
        return input;
    }

    return null;
}

function parseIsoWeekday(input, locale) {
    if (typeof input === 'string') {
        return locale.weekdaysParse(input) % 7 || 7;
    }
    return isNaN(input) ? null : input;
}

// LOCALES

var defaultLocaleWeekdays = 'Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday'.split('_');
function localeWeekdays (m, format) {
    if (!m) {
        return isArray(this._weekdays) ? this._weekdays :
            this._weekdays['standalone'];
    }
    return isArray(this._weekdays) ? this._weekdays[m.day()] :
        this._weekdays[this._weekdays.isFormat.test(format) ? 'format' : 'standalone'][m.day()];
}

var defaultLocaleWeekdaysShort = 'Sun_Mon_Tue_Wed_Thu_Fri_Sat'.split('_');
function localeWeekdaysShort (m) {
    return (m) ? this._weekdaysShort[m.day()] : this._weekdaysShort;
}

var defaultLocaleWeekdaysMin = 'Su_Mo_Tu_We_Th_Fr_Sa'.split('_');
function localeWeekdaysMin (m) {
    return (m) ? this._weekdaysMin[m.day()] : this._weekdaysMin;
}

function handleStrictParse$1(weekdayName, format, strict) {
    var i, ii, mom, llc = weekdayName.toLocaleLowerCase();
    if (!this._weekdaysParse) {
        this._weekdaysParse = [];
        this._shortWeekdaysParse = [];
        this._minWeekdaysParse = [];

        for (i = 0; i < 7; ++i) {
            mom = createUTC([2000, 1]).day(i);
            this._minWeekdaysParse[i] = this.weekdaysMin(mom, '').toLocaleLowerCase();
            this._shortWeekdaysParse[i] = this.weekdaysShort(mom, '').toLocaleLowerCase();
            this._weekdaysParse[i] = this.weekdays(mom, '').toLocaleLowerCase();
        }
    }

    if (strict) {
        if (format === 'dddd') {
            ii = indexOf.call(this._weekdaysParse, llc);
            return ii !== -1 ? ii : null;
        } else if (format === 'ddd') {
            ii = indexOf.call(this._shortWeekdaysParse, llc);
            return ii !== -1 ? ii : null;
        } else {
            ii = indexOf.call(this._minWeekdaysParse, llc);
            return ii !== -1 ? ii : null;
        }
    } else {
        if (format === 'dddd') {
            ii = indexOf.call(this._weekdaysParse, llc);
            if (ii !== -1) {
                return ii;
            }
            ii = indexOf.call(this._shortWeekdaysParse, llc);
            if (ii !== -1) {
                return ii;
            }
            ii = indexOf.call(this._minWeekdaysParse, llc);
            return ii !== -1 ? ii : null;
        } else if (format === 'ddd') {
            ii = indexOf.call(this._shortWeekdaysParse, llc);
            if (ii !== -1) {
                return ii;
            }
            ii = indexOf.call(this._weekdaysParse, llc);
            if (ii !== -1) {
                return ii;
            }
            ii = indexOf.call(this._minWeekdaysParse, llc);
            return ii !== -1 ? ii : null;
        } else {
            ii = indexOf.call(this._minWeekdaysParse, llc);
            if (ii !== -1) {
                return ii;
            }
            ii = indexOf.call(this._weekdaysParse, llc);
            if (ii !== -1) {
                return ii;
            }
            ii = indexOf.call(this._shortWeekdaysParse, llc);
            return ii !== -1 ? ii : null;
        }
    }
}

function localeWeekdaysParse (weekdayName, format, strict) {
    var i, mom, regex;

    if (this._weekdaysParseExact) {
        return handleStrictParse$1.call(this, weekdayName, format, strict);
    }

    if (!this._weekdaysParse) {
        this._weekdaysParse = [];
        this._minWeekdaysParse = [];
        this._shortWeekdaysParse = [];
        this._fullWeekdaysParse = [];
    }

    for (i = 0; i < 7; i++) {
        // make the regex if we don't have it already

        mom = createUTC([2000, 1]).day(i);
        if (strict && !this._fullWeekdaysParse[i]) {
            this._fullWeekdaysParse[i] = new RegExp('^' + this.weekdays(mom, '').replace('.', '\.?') + '$', 'i');
            this._shortWeekdaysParse[i] = new RegExp('^' + this.weekdaysShort(mom, '').replace('.', '\.?') + '$', 'i');
            this._minWeekdaysParse[i] = new RegExp('^' + this.weekdaysMin(mom, '').replace('.', '\.?') + '$', 'i');
        }
        if (!this._weekdaysParse[i]) {
            regex = '^' + this.weekdays(mom, '') + '|^' + this.weekdaysShort(mom, '') + '|^' + this.weekdaysMin(mom, '');
            this._weekdaysParse[i] = new RegExp(regex.replace('.', ''), 'i');
        }
        // test the regex
        if (strict && format === 'dddd' && this._fullWeekdaysParse[i].test(weekdayName)) {
            return i;
        } else if (strict && format === 'ddd' && this._shortWeekdaysParse[i].test(weekdayName)) {
            return i;
        } else if (strict && format === 'dd' && this._minWeekdaysParse[i].test(weekdayName)) {
            return i;
        } else if (!strict && this._weekdaysParse[i].test(weekdayName)) {
            return i;
        }
    }
}

// MOMENTS

function getSetDayOfWeek (input) {
    if (!this.isValid()) {
        return input != null ? this : NaN;
    }
    var day = this._isUTC ? this._d.getUTCDay() : this._d.getDay();
    if (input != null) {
        input = parseWeekday(input, this.localeData());
        return this.add(input - day, 'd');
    } else {
        return day;
    }
}

function getSetLocaleDayOfWeek (input) {
    if (!this.isValid()) {
        return input != null ? this : NaN;
    }
    var weekday = (this.day() + 7 - this.localeData()._week.dow) % 7;
    return input == null ? weekday : this.add(input - weekday, 'd');
}

function getSetISODayOfWeek (input) {
    if (!this.isValid()) {
        return input != null ? this : NaN;
    }

    // behaves the same as moment#day except
    // as a getter, returns 7 instead of 0 (1-7 range instead of 0-6)
    // as a setter, sunday should belong to the previous week.

    if (input != null) {
        var weekday = parseIsoWeekday(input, this.localeData());
        return this.day(this.day() % 7 ? weekday : weekday - 7);
    } else {
        return this.day() || 7;
    }
}

var defaultWeekdaysRegex = matchWord;
function weekdaysRegex (isStrict) {
    if (this._weekdaysParseExact) {
        if (!hasOwnProp(this, '_weekdaysRegex')) {
            computeWeekdaysParse.call(this);
        }
        if (isStrict) {
            return this._weekdaysStrictRegex;
        } else {
            return this._weekdaysRegex;
        }
    } else {
        if (!hasOwnProp(this, '_weekdaysRegex')) {
            this._weekdaysRegex = defaultWeekdaysRegex;
        }
        return this._weekdaysStrictRegex && isStrict ?
            this._weekdaysStrictRegex : this._weekdaysRegex;
    }
}

var defaultWeekdaysShortRegex = matchWord;
function weekdaysShortRegex (isStrict) {
    if (this._weekdaysParseExact) {
        if (!hasOwnProp(this, '_weekdaysRegex')) {
            computeWeekdaysParse.call(this);
        }
        if (isStrict) {
            return this._weekdaysShortStrictRegex;
        } else {
            return this._weekdaysShortRegex;
        }
    } else {
        if (!hasOwnProp(this, '_weekdaysShortRegex')) {
            this._weekdaysShortRegex = defaultWeekdaysShortRegex;
        }
        return this._weekdaysShortStrictRegex && isStrict ?
            this._weekdaysShortStrictRegex : this._weekdaysShortRegex;
    }
}

var defaultWeekdaysMinRegex = matchWord;
function weekdaysMinRegex (isStrict) {
    if (this._weekdaysParseExact) {
        if (!hasOwnProp(this, '_weekdaysRegex')) {
            computeWeekdaysParse.call(this);
        }
        if (isStrict) {
            return this._weekdaysMinStrictRegex;
        } else {
            return this._weekdaysMinRegex;
        }
    } else {
        if (!hasOwnProp(this, '_weekdaysMinRegex')) {
            this._weekdaysMinRegex = defaultWeekdaysMinRegex;
        }
        return this._weekdaysMinStrictRegex && isStrict ?
            this._weekdaysMinStrictRegex : this._weekdaysMinRegex;
    }
}


function computeWeekdaysParse () {
    function cmpLenRev(a, b) {
        return b.length - a.length;
    }

    var minPieces = [], shortPieces = [], longPieces = [], mixedPieces = [],
        i, mom, minp, shortp, longp;
    for (i = 0; i < 7; i++) {
        // make the regex if we don't have it already
        mom = createUTC([2000, 1]).day(i);
        minp = this.weekdaysMin(mom, '');
        shortp = this.weekdaysShort(mom, '');
        longp = this.weekdays(mom, '');
        minPieces.push(minp);
        shortPieces.push(shortp);
        longPieces.push(longp);
        mixedPieces.push(minp);
        mixedPieces.push(shortp);
        mixedPieces.push(longp);
    }
    // Sorting makes sure if one weekday (or abbr) is a prefix of another it
    // will match the longer piece.
    minPieces.sort(cmpLenRev);
    shortPieces.sort(cmpLenRev);
    longPieces.sort(cmpLenRev);
    mixedPieces.sort(cmpLenRev);
    for (i = 0; i < 7; i++) {
        shortPieces[i] = regexEscape(shortPieces[i]);
        longPieces[i] = regexEscape(longPieces[i]);
        mixedPieces[i] = regexEscape(mixedPieces[i]);
    }

    this._weekdaysRegex = new RegExp('^(' + mixedPieces.join('|') + ')', 'i');
    this._weekdaysShortRegex = this._weekdaysRegex;
    this._weekdaysMinRegex = this._weekdaysRegex;

    this._weekdaysStrictRegex = new RegExp('^(' + longPieces.join('|') + ')', 'i');
    this._weekdaysShortStrictRegex = new RegExp('^(' + shortPieces.join('|') + ')', 'i');
    this._weekdaysMinStrictRegex = new RegExp('^(' + minPieces.join('|') + ')', 'i');
}

// FORMATTING

function hFormat() {
    return this.hours() % 12 || 12;
}

function kFormat() {
    return this.hours() || 24;
}

addFormatToken('H', ['HH', 2], 0, 'hour');
addFormatToken('h', ['hh', 2], 0, hFormat);
addFormatToken('k', ['kk', 2], 0, kFormat);

addFormatToken('hmm', 0, 0, function () {
    return '' + hFormat.apply(this) + zeroFill(this.minutes(), 2);
});

addFormatToken('hmmss', 0, 0, function () {
    return '' + hFormat.apply(this) + zeroFill(this.minutes(), 2) +
        zeroFill(this.seconds(), 2);
});

addFormatToken('Hmm', 0, 0, function () {
    return '' + this.hours() + zeroFill(this.minutes(), 2);
});

addFormatToken('Hmmss', 0, 0, function () {
    return '' + this.hours() + zeroFill(this.minutes(), 2) +
        zeroFill(this.seconds(), 2);
});

function meridiem (token, lowercase) {
    addFormatToken(token, 0, 0, function () {
        return this.localeData().meridiem(this.hours(), this.minutes(), lowercase);
    });
}

meridiem('a', true);
meridiem('A', false);

// ALIASES

addUnitAlias('hour', 'h');

// PRIORITY
addUnitPriority('hour', 13);

// PARSING

function matchMeridiem (isStrict, locale) {
    return locale._meridiemParse;
}

addRegexToken('a',  matchMeridiem);
addRegexToken('A',  matchMeridiem);
addRegexToken('H',  match1to2);
addRegexToken('h',  match1to2);
addRegexToken('k',  match1to2);
addRegexToken('HH', match1to2, match2);
addRegexToken('hh', match1to2, match2);
addRegexToken('kk', match1to2, match2);

addRegexToken('hmm', match3to4);
addRegexToken('hmmss', match5to6);
addRegexToken('Hmm', match3to4);
addRegexToken('Hmmss', match5to6);

addParseToken(['H', 'HH'], HOUR);
addParseToken(['k', 'kk'], function (input, array, config) {
    var kInput = toInt(input);
    array[HOUR] = kInput === 24 ? 0 : kInput;
});
addParseToken(['a', 'A'], function (input, array, config) {
    config._isPm = config._locale.isPM(input);
    config._meridiem = input;
});
addParseToken(['h', 'hh'], function (input, array, config) {
    array[HOUR] = toInt(input);
    getParsingFlags(config).bigHour = true;
});
addParseToken('hmm', function (input, array, config) {
    var pos = input.length - 2;
    array[HOUR] = toInt(input.substr(0, pos));
    array[MINUTE] = toInt(input.substr(pos));
    getParsingFlags(config).bigHour = true;
});
addParseToken('hmmss', function (input, array, config) {
    var pos1 = input.length - 4;
    var pos2 = input.length - 2;
    array[HOUR] = toInt(input.substr(0, pos1));
    array[MINUTE] = toInt(input.substr(pos1, 2));
    array[SECOND] = toInt(input.substr(pos2));
    getParsingFlags(config).bigHour = true;
});
addParseToken('Hmm', function (input, array, config) {
    var pos = input.length - 2;
    array[HOUR] = toInt(input.substr(0, pos));
    array[MINUTE] = toInt(input.substr(pos));
});
addParseToken('Hmmss', function (input, array, config) {
    var pos1 = input.length - 4;
    var pos2 = input.length - 2;
    array[HOUR] = toInt(input.substr(0, pos1));
    array[MINUTE] = toInt(input.substr(pos1, 2));
    array[SECOND] = toInt(input.substr(pos2));
});

// LOCALES

function localeIsPM (input) {
    // IE8 Quirks Mode & IE7 Standards Mode do not allow accessing strings like arrays
    // Using charAt should be more compatible.
    return ((input + '').toLowerCase().charAt(0) === 'p');
}

var defaultLocaleMeridiemParse = /[ap]\.?m?\.?/i;
function localeMeridiem (hours, minutes, isLower) {
    if (hours > 11) {
        return isLower ? 'pm' : 'PM';
    } else {
        return isLower ? 'am' : 'AM';
    }
}


// MOMENTS

// Setting the hour should keep the time, because the user explicitly
// specified which hour he wants. So trying to maintain the same hour (in
// a new timezone) makes sense. Adding/subtracting hours does not follow
// this rule.
var getSetHour = makeGetSet('Hours', true);

// months
// week
// weekdays
// meridiem
var baseConfig = {
    calendar: defaultCalendar,
    longDateFormat: defaultLongDateFormat,
    invalidDate: defaultInvalidDate,
    ordinal: defaultOrdinal,
    dayOfMonthOrdinalParse: defaultDayOfMonthOrdinalParse,
    relativeTime: defaultRelativeTime,

    months: defaultLocaleMonths,
    monthsShort: defaultLocaleMonthsShort,

    week: defaultLocaleWeek,

    weekdays: defaultLocaleWeekdays,
    weekdaysMin: defaultLocaleWeekdaysMin,
    weekdaysShort: defaultLocaleWeekdaysShort,

    meridiemParse: defaultLocaleMeridiemParse
};

// internal storage for locale config files
var locales = {};
var localeFamilies = {};
var globalLocale;

function normalizeLocale(key) {
    return key ? key.toLowerCase().replace('_', '-') : key;
}

// pick the locale from the array
// try ['en-au', 'en-gb'] as 'en-au', 'en-gb', 'en', as in move through the list trying each
// substring from most specific to least, but move to the next array item if it's a more specific variant than the current root
function chooseLocale(names) {
    var i = 0, j, next, locale, split;

    while (i < names.length) {
        split = normalizeLocale(names[i]).split('-');
        j = split.length;
        next = normalizeLocale(names[i + 1]);
        next = next ? next.split('-') : null;
        while (j > 0) {
            locale = loadLocale(split.slice(0, j).join('-'));
            if (locale) {
                return locale;
            }
            if (next && next.length >= j && compareArrays(split, next, true) >= j - 1) {
                //the next array item is better than a shallower substring of this one
                break;
            }
            j--;
        }
        i++;
    }
    return null;
}

function loadLocale(name) {
    var oldLocale = null;
    // TODO: Find a better way to register and load all the locales in Node
    if (!locales[name] && (typeof module !== 'undefined') &&
            module && module.exports) {
        try {
            oldLocale = globalLocale._abbr;
            var aliasedRequire = require;
            aliasedRequire('./locale/' + name);
            getSetGlobalLocale(oldLocale);
        } catch (e) {}
    }
    return locales[name];
}

// This function will load locale and then set the global locale.  If
// no arguments are passed in, it will simply return the current global
// locale key.
function getSetGlobalLocale (key, values) {
    var data;
    if (key) {
        if (isUndefined(values)) {
            data = getLocale(key);
        }
        else {
            data = defineLocale(key, values);
        }

        if (data) {
            // moment.duration._locale = moment._locale = data;
            globalLocale = data;
        }
    }

    return globalLocale._abbr;
}

function defineLocale (name, config) {
    if (config !== null) {
        var parentConfig = baseConfig;
        config.abbr = name;
        if (locales[name] != null) {
            deprecateSimple('defineLocaleOverride',
                    'use moment.updateLocale(localeName, config) to change ' +
                    'an existing locale. moment.defineLocale(localeName, ' +
                    'config) should only be used for creating a new locale ' +
                    'See http://momentjs.com/guides/#/warnings/define-locale/ for more info.');
            parentConfig = locales[name]._config;
        } else if (config.parentLocale != null) {
            if (locales[config.parentLocale] != null) {
                parentConfig = locales[config.parentLocale]._config;
            } else {
                if (!localeFamilies[config.parentLocale]) {
                    localeFamilies[config.parentLocale] = [];
                }
                localeFamilies[config.parentLocale].push({
                    name: name,
                    config: config
                });
                return null;
            }
        }
        locales[name] = new Locale(mergeConfigs(parentConfig, config));

        if (localeFamilies[name]) {
            localeFamilies[name].forEach(function (x) {
                defineLocale(x.name, x.config);
            });
        }

        // backwards compat for now: also set the locale
        // make sure we set the locale AFTER all child locales have been
        // created, so we won't end up with the child locale set.
        getSetGlobalLocale(name);


        return locales[name];
    } else {
        // useful for testing
        delete locales[name];
        return null;
    }
}

function updateLocale(name, config) {
    if (config != null) {
        var locale, parentConfig = baseConfig;
        // MERGE
        if (locales[name] != null) {
            parentConfig = locales[name]._config;
        }
        config = mergeConfigs(parentConfig, config);
        locale = new Locale(config);
        locale.parentLocale = locales[name];
        locales[name] = locale;

        // backwards compat for now: also set the locale
        getSetGlobalLocale(name);
    } else {
        // pass null for config to unupdate, useful for tests
        if (locales[name] != null) {
            if (locales[name].parentLocale != null) {
                locales[name] = locales[name].parentLocale;
            } else if (locales[name] != null) {
                delete locales[name];
            }
        }
    }
    return locales[name];
}

// returns locale data
function getLocale (key) {
    var locale;

    if (key && key._locale && key._locale._abbr) {
        key = key._locale._abbr;
    }

    if (!key) {
        return globalLocale;
    }

    if (!isArray(key)) {
        //short-circuit everything else
        locale = loadLocale(key);
        if (locale) {
            return locale;
        }
        key = [key];
    }

    return chooseLocale(key);
}

function listLocales() {
    return keys(locales);
}

function checkOverflow (m) {
    var overflow;
    var a = m._a;

    if (a && getParsingFlags(m).overflow === -2) {
        overflow =
            a[MONTH]       < 0 || a[MONTH]       > 11  ? MONTH :
            a[DATE]        < 1 || a[DATE]        > daysInMonth(a[YEAR], a[MONTH]) ? DATE :
            a[HOUR]        < 0 || a[HOUR]        > 24 || (a[HOUR] === 24 && (a[MINUTE] !== 0 || a[SECOND] !== 0 || a[MILLISECOND] !== 0)) ? HOUR :
            a[MINUTE]      < 0 || a[MINUTE]      > 59  ? MINUTE :
            a[SECOND]      < 0 || a[SECOND]      > 59  ? SECOND :
            a[MILLISECOND] < 0 || a[MILLISECOND] > 999 ? MILLISECOND :
            -1;

        if (getParsingFlags(m)._overflowDayOfYear && (overflow < YEAR || overflow > DATE)) {
            overflow = DATE;
        }
        if (getParsingFlags(m)._overflowWeeks && overflow === -1) {
            overflow = WEEK;
        }
        if (getParsingFlags(m)._overflowWeekday && overflow === -1) {
            overflow = WEEKDAY;
        }

        getParsingFlags(m).overflow = overflow;
    }

    return m;
}

// Pick the first defined of two or three arguments.
function defaults(a, b, c) {
    if (a != null) {
        return a;
    }
    if (b != null) {
        return b;
    }
    return c;
}

function currentDateArray(config) {
    // hooks is actually the exported moment object
    var nowValue = new Date(hooks.now());
    if (config._useUTC) {
        return [nowValue.getUTCFullYear(), nowValue.getUTCMonth(), nowValue.getUTCDate()];
    }
    return [nowValue.getFullYear(), nowValue.getMonth(), nowValue.getDate()];
}

// convert an array to a date.
// the array should mirror the parameters below
// note: all values past the year are optional and will default to the lowest possible value.
// [year, month, day , hour, minute, second, millisecond]
function configFromArray (config) {
    var i, date, input = [], currentDate, yearToUse;

    if (config._d) {
        return;
    }

    currentDate = currentDateArray(config);

    //compute day of the year from weeks and weekdays
    if (config._w && config._a[DATE] == null && config._a[MONTH] == null) {
        dayOfYearFromWeekInfo(config);
    }

    //if the day of the year is set, figure out what it is
    if (config._dayOfYear != null) {
        yearToUse = defaults(config._a[YEAR], currentDate[YEAR]);

        if (config._dayOfYear > daysInYear(yearToUse) || config._dayOfYear === 0) {
            getParsingFlags(config)._overflowDayOfYear = true;
        }

        date = createUTCDate(yearToUse, 0, config._dayOfYear);
        config._a[MONTH] = date.getUTCMonth();
        config._a[DATE] = date.getUTCDate();
    }

    // Default to current date.
    // * if no year, month, day of month are given, default to today
    // * if day of month is given, default month and year
    // * if month is given, default only year
    // * if year is given, don't default anything
    for (i = 0; i < 3 && config._a[i] == null; ++i) {
        config._a[i] = input[i] = currentDate[i];
    }

    // Zero out whatever was not defaulted, including time
    for (; i < 7; i++) {
        config._a[i] = input[i] = (config._a[i] == null) ? (i === 2 ? 1 : 0) : config._a[i];
    }

    // Check for 24:00:00.000
    if (config._a[HOUR] === 24 &&
            config._a[MINUTE] === 0 &&
            config._a[SECOND] === 0 &&
            config._a[MILLISECOND] === 0) {
        config._nextDay = true;
        config._a[HOUR] = 0;
    }

    config._d = (config._useUTC ? createUTCDate : createDate).apply(null, input);
    // Apply timezone offset from input. The actual utcOffset can be changed
    // with parseZone.
    if (config._tzm != null) {
        config._d.setUTCMinutes(config._d.getUTCMinutes() - config._tzm);
    }

    if (config._nextDay) {
        config._a[HOUR] = 24;
    }

    // check for mismatching day of week
    if (config._w && typeof config._w.d !== 'undefined' && config._w.d !== config._d.getDay()) {
        getParsingFlags(config).weekdayMismatch = true;
    }
}

function dayOfYearFromWeekInfo(config) {
    var w, weekYear, week, weekday, dow, doy, temp, weekdayOverflow;

    w = config._w;
    if (w.GG != null || w.W != null || w.E != null) {
        dow = 1;
        doy = 4;

        // TODO: We need to take the current isoWeekYear, but that depends on
        // how we interpret now (local, utc, fixed offset). So create
        // a now version of current config (take local/utc/offset flags, and
        // create now).
        weekYear = defaults(w.GG, config._a[YEAR], weekOfYear(createLocal(), 1, 4).year);
        week = defaults(w.W, 1);
        weekday = defaults(w.E, 1);
        if (weekday < 1 || weekday > 7) {
            weekdayOverflow = true;
        }
    } else {
        dow = config._locale._week.dow;
        doy = config._locale._week.doy;

        var curWeek = weekOfYear(createLocal(), dow, doy);

        weekYear = defaults(w.gg, config._a[YEAR], curWeek.year);

        // Default to current week.
        week = defaults(w.w, curWeek.week);

        if (w.d != null) {
            // weekday -- low day numbers are considered next week
            weekday = w.d;
            if (weekday < 0 || weekday > 6) {
                weekdayOverflow = true;
            }
        } else if (w.e != null) {
            // local weekday -- counting starts from begining of week
            weekday = w.e + dow;
            if (w.e < 0 || w.e > 6) {
                weekdayOverflow = true;
            }
        } else {
            // default to begining of week
            weekday = dow;
        }
    }
    if (week < 1 || week > weeksInYear(weekYear, dow, doy)) {
        getParsingFlags(config)._overflowWeeks = true;
    } else if (weekdayOverflow != null) {
        getParsingFlags(config)._overflowWeekday = true;
    } else {
        temp = dayOfYearFromWeeks(weekYear, week, weekday, dow, doy);
        config._a[YEAR] = temp.year;
        config._dayOfYear = temp.dayOfYear;
    }
}

// iso 8601 regex
// 0000-00-00 0000-W00 or 0000-W00-0 + T + 00 or 00:00 or 00:00:00 or 00:00:00.000 + +00:00 or +0000 or +00)
var extendedIsoRegex = /^\s*((?:[+-]\d{6}|\d{4})-(?:\d\d-\d\d|W\d\d-\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?::\d\d(?::\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?$/;
var basicIsoRegex = /^\s*((?:[+-]\d{6}|\d{4})(?:\d\d\d\d|W\d\d\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?:\d\d(?:\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?$/;

var tzRegex = /Z|[+-]\d\d(?::?\d\d)?/;

var isoDates = [
    ['YYYYYY-MM-DD', /[+-]\d{6}-\d\d-\d\d/],
    ['YYYY-MM-DD', /\d{4}-\d\d-\d\d/],
    ['GGGG-[W]WW-E', /\d{4}-W\d\d-\d/],
    ['GGGG-[W]WW', /\d{4}-W\d\d/, false],
    ['YYYY-DDD', /\d{4}-\d{3}/],
    ['YYYY-MM', /\d{4}-\d\d/, false],
    ['YYYYYYMMDD', /[+-]\d{10}/],
    ['YYYYMMDD', /\d{8}/],
    // YYYYMM is NOT allowed by the standard
    ['GGGG[W]WWE', /\d{4}W\d{3}/],
    ['GGGG[W]WW', /\d{4}W\d{2}/, false],
    ['YYYYDDD', /\d{7}/]
];

// iso time formats and regexes
var isoTimes = [
    ['HH:mm:ss.SSSS', /\d\d:\d\d:\d\d\.\d+/],
    ['HH:mm:ss,SSSS', /\d\d:\d\d:\d\d,\d+/],
    ['HH:mm:ss', /\d\d:\d\d:\d\d/],
    ['HH:mm', /\d\d:\d\d/],
    ['HHmmss.SSSS', /\d\d\d\d\d\d\.\d+/],
    ['HHmmss,SSSS', /\d\d\d\d\d\d,\d+/],
    ['HHmmss', /\d\d\d\d\d\d/],
    ['HHmm', /\d\d\d\d/],
    ['HH', /\d\d/]
];

var aspNetJsonRegex = /^\/?Date\((\-?\d+)/i;

// date from iso format
function configFromISO(config) {
    var i, l,
        string = config._i,
        match = extendedIsoRegex.exec(string) || basicIsoRegex.exec(string),
        allowTime, dateFormat, timeFormat, tzFormat;

    if (match) {
        getParsingFlags(config).iso = true;

        for (i = 0, l = isoDates.length; i < l; i++) {
            if (isoDates[i][1].exec(match[1])) {
                dateFormat = isoDates[i][0];
                allowTime = isoDates[i][2] !== false;
                break;
            }
        }
        if (dateFormat == null) {
            config._isValid = false;
            return;
        }
        if (match[3]) {
            for (i = 0, l = isoTimes.length; i < l; i++) {
                if (isoTimes[i][1].exec(match[3])) {
                    // match[2] should be 'T' or space
                    timeFormat = (match[2] || ' ') + isoTimes[i][0];
                    break;
                }
            }
            if (timeFormat == null) {
                config._isValid = false;
                return;
            }
        }
        if (!allowTime && timeFormat != null) {
            config._isValid = false;
            return;
        }
        if (match[4]) {
            if (tzRegex.exec(match[4])) {
                tzFormat = 'Z';
            } else {
                config._isValid = false;
                return;
            }
        }
        config._f = dateFormat + (timeFormat || '') + (tzFormat || '');
        configFromStringAndFormat(config);
    } else {
        config._isValid = false;
    }
}

// RFC 2822 regex: For details see https://tools.ietf.org/html/rfc2822#section-3.3
var rfc2822 = /^(?:(Mon|Tue|Wed|Thu|Fri|Sat|Sun),?\s)?(\d{1,2})\s(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s(\d{2,4})\s(\d\d):(\d\d)(?::(\d\d))?\s(?:(UT|GMT|[ECMP][SD]T)|([Zz])|([+-]\d{4}))$/;

function extractFromRFC2822Strings(yearStr, monthStr, dayStr, hourStr, minuteStr, secondStr) {
    var result = [
        untruncateYear(yearStr),
        defaultLocaleMonthsShort.indexOf(monthStr),
        parseInt(dayStr, 10),
        parseInt(hourStr, 10),
        parseInt(minuteStr, 10)
    ];

    if (secondStr) {
        result.push(parseInt(secondStr, 10));
    }

    return result;
}

function untruncateYear(yearStr) {
    var year = parseInt(yearStr, 10);
    if (year <= 49) {
        return 2000 + year;
    } else if (year <= 999) {
        return 1900 + year;
    }
    return year;
}

function preprocessRFC2822(s) {
    // Remove comments and folding whitespace and replace multiple-spaces with a single space
    return s.replace(/\([^)]*\)|[\n\t]/g, ' ').replace(/(\s\s+)/g, ' ').trim();
}

function checkWeekday(weekdayStr, parsedInput, config) {
    if (weekdayStr) {
        // TODO: Replace the vanilla JS Date object with an indepentent day-of-week check.
        var weekdayProvided = defaultLocaleWeekdaysShort.indexOf(weekdayStr),
            weekdayActual = new Date(parsedInput[0], parsedInput[1], parsedInput[2]).getDay();
        if (weekdayProvided !== weekdayActual) {
            getParsingFlags(config).weekdayMismatch = true;
            config._isValid = false;
            return false;
        }
    }
    return true;
}

var obsOffsets = {
    UT: 0,
    GMT: 0,
    EDT: -4 * 60,
    EST: -5 * 60,
    CDT: -5 * 60,
    CST: -6 * 60,
    MDT: -6 * 60,
    MST: -7 * 60,
    PDT: -7 * 60,
    PST: -8 * 60
};

function calculateOffset(obsOffset, militaryOffset, numOffset) {
    if (obsOffset) {
        return obsOffsets[obsOffset];
    } else if (militaryOffset) {
        // the only allowed military tz is Z
        return 0;
    } else {
        var hm = parseInt(numOffset, 10);
        var m = hm % 100, h = (hm - m) / 100;
        return h * 60 + m;
    }
}

// date and time from ref 2822 format
function configFromRFC2822(config) {
    var match = rfc2822.exec(preprocessRFC2822(config._i));
    if (match) {
        var parsedArray = extractFromRFC2822Strings(match[4], match[3], match[2], match[5], match[6], match[7]);
        if (!checkWeekday(match[1], parsedArray, config)) {
            return;
        }

        config._a = parsedArray;
        config._tzm = calculateOffset(match[8], match[9], match[10]);

        config._d = createUTCDate.apply(null, config._a);
        config._d.setUTCMinutes(config._d.getUTCMinutes() - config._tzm);

        getParsingFlags(config).rfc2822 = true;
    } else {
        config._isValid = false;
    }
}

// date from iso format or fallback
function configFromString(config) {
    var matched = aspNetJsonRegex.exec(config._i);

    if (matched !== null) {
        config._d = new Date(+matched[1]);
        return;
    }

    configFromISO(config);
    if (config._isValid === false) {
        delete config._isValid;
    } else {
        return;
    }

    configFromRFC2822(config);
    if (config._isValid === false) {
        delete config._isValid;
    } else {
        return;
    }

    // Final attempt, use Input Fallback
    hooks.createFromInputFallback(config);
}

hooks.createFromInputFallback = deprecate(
    'value provided is not in a recognized RFC2822 or ISO format. moment construction falls back to js Date(), ' +
    'which is not reliable across all browsers and versions. Non RFC2822/ISO date formats are ' +
    'discouraged and will be removed in an upcoming major release. Please refer to ' +
    'http://momentjs.com/guides/#/warnings/js-date/ for more info.',
    function (config) {
        config._d = new Date(config._i + (config._useUTC ? ' UTC' : ''));
    }
);

// constant that refers to the ISO standard
hooks.ISO_8601 = function () {};

// constant that refers to the RFC 2822 form
hooks.RFC_2822 = function () {};

// date from string and format string
function configFromStringAndFormat(config) {
    // TODO: Move this to another part of the creation flow to prevent circular deps
    if (config._f === hooks.ISO_8601) {
        configFromISO(config);
        return;
    }
    if (config._f === hooks.RFC_2822) {
        configFromRFC2822(config);
        return;
    }
    config._a = [];
    getParsingFlags(config).empty = true;

    // This array is used to make a Date, either with `new Date` or `Date.UTC`
    var string = '' + config._i,
        i, parsedInput, tokens, token, skipped,
        stringLength = string.length,
        totalParsedInputLength = 0;

    tokens = expandFormat(config._f, config._locale).match(formattingTokens) || [];

    for (i = 0; i < tokens.length; i++) {
        token = tokens[i];
        parsedInput = (string.match(getParseRegexForToken(token, config)) || [])[0];
        // console.log('token', token, 'parsedInput', parsedInput,
        //         'regex', getParseRegexForToken(token, config));
        if (parsedInput) {
            skipped = string.substr(0, string.indexOf(parsedInput));
            if (skipped.length > 0) {
                getParsingFlags(config).unusedInput.push(skipped);
            }
            string = string.slice(string.indexOf(parsedInput) + parsedInput.length);
            totalParsedInputLength += parsedInput.length;
        }
        // don't parse if it's not a known token
        if (formatTokenFunctions[token]) {
            if (parsedInput) {
                getParsingFlags(config).empty = false;
            }
            else {
                getParsingFlags(config).unusedTokens.push(token);
            }
            addTimeToArrayFromToken(token, parsedInput, config);
        }
        else if (config._strict && !parsedInput) {
            getParsingFlags(config).unusedTokens.push(token);
        }
    }

    // add remaining unparsed input length to the string
    getParsingFlags(config).charsLeftOver = stringLength - totalParsedInputLength;
    if (string.length > 0) {
        getParsingFlags(config).unusedInput.push(string);
    }

    // clear _12h flag if hour is <= 12
    if (config._a[HOUR] <= 12 &&
        getParsingFlags(config).bigHour === true &&
        config._a[HOUR] > 0) {
        getParsingFlags(config).bigHour = undefined;
    }

    getParsingFlags(config).parsedDateParts = config._a.slice(0);
    getParsingFlags(config).meridiem = config._meridiem;
    // handle meridiem
    config._a[HOUR] = meridiemFixWrap(config._locale, config._a[HOUR], config._meridiem);

    configFromArray(config);
    checkOverflow(config);
}


function meridiemFixWrap (locale, hour, meridiem) {
    var isPm;

    if (meridiem == null) {
        // nothing to do
        return hour;
    }
    if (locale.meridiemHour != null) {
        return locale.meridiemHour(hour, meridiem);
    } else if (locale.isPM != null) {
        // Fallback
        isPm = locale.isPM(meridiem);
        if (isPm && hour < 12) {
            hour += 12;
        }
        if (!isPm && hour === 12) {
            hour = 0;
        }
        return hour;
    } else {
        // this is not supposed to happen
        return hour;
    }
}

// date from string and array of format strings
function configFromStringAndArray(config) {
    var tempConfig,
        bestMoment,

        scoreToBeat,
        i,
        currentScore;

    if (config._f.length === 0) {
        getParsingFlags(config).invalidFormat = true;
        config._d = new Date(NaN);
        return;
    }

    for (i = 0; i < config._f.length; i++) {
        currentScore = 0;
        tempConfig = copyConfig({}, config);
        if (config._useUTC != null) {
            tempConfig._useUTC = config._useUTC;
        }
        tempConfig._f = config._f[i];
        configFromStringAndFormat(tempConfig);

        if (!isValid(tempConfig)) {
            continue;
        }

        // if there is any input that was not parsed add a penalty for that format
        currentScore += getParsingFlags(tempConfig).charsLeftOver;

        //or tokens
        currentScore += getParsingFlags(tempConfig).unusedTokens.length * 10;

        getParsingFlags(tempConfig).score = currentScore;

        if (scoreToBeat == null || currentScore < scoreToBeat) {
            scoreToBeat = currentScore;
            bestMoment = tempConfig;
        }
    }

    extend(config, bestMoment || tempConfig);
}

function configFromObject(config) {
    if (config._d) {
        return;
    }

    var i = normalizeObjectUnits(config._i);
    config._a = map([i.year, i.month, i.day || i.date, i.hour, i.minute, i.second, i.millisecond], function (obj) {
        return obj && parseInt(obj, 10);
    });

    configFromArray(config);
}

function createFromConfig (config) {
    var res = new Moment(checkOverflow(prepareConfig(config)));
    if (res._nextDay) {
        // Adding is smart enough around DST
        res.add(1, 'd');
        res._nextDay = undefined;
    }

    return res;
}

function prepareConfig (config) {
    var input = config._i,
        format = config._f;

    config._locale = config._locale || getLocale(config._l);

    if (input === null || (format === undefined && input === '')) {
        return createInvalid({nullInput: true});
    }

    if (typeof input === 'string') {
        config._i = input = config._locale.preparse(input);
    }

    if (isMoment(input)) {
        return new Moment(checkOverflow(input));
    } else if (isDate(input)) {
        config._d = input;
    } else if (isArray(format)) {
        configFromStringAndArray(config);
    } else if (format) {
        configFromStringAndFormat(config);
    }  else {
        configFromInput(config);
    }

    if (!isValid(config)) {
        config._d = null;
    }

    return config;
}

function configFromInput(config) {
    var input = config._i;
    if (isUndefined(input)) {
        config._d = new Date(hooks.now());
    } else if (isDate(input)) {
        config._d = new Date(input.valueOf());
    } else if (typeof input === 'string') {
        configFromString(config);
    } else if (isArray(input)) {
        config._a = map(input.slice(0), function (obj) {
            return parseInt(obj, 10);
        });
        configFromArray(config);
    } else if (isObject(input)) {
        configFromObject(config);
    } else if (isNumber(input)) {
        // from milliseconds
        config._d = new Date(input);
    } else {
        hooks.createFromInputFallback(config);
    }
}

function createLocalOrUTC (input, format, locale, strict, isUTC) {
    var c = {};

    if (locale === true || locale === false) {
        strict = locale;
        locale = undefined;
    }

    if ((isObject(input) && isObjectEmpty(input)) ||
            (isArray(input) && input.length === 0)) {
        input = undefined;
    }
    // object construction must be done this way.
    // https://github.com/moment/moment/issues/1423
    c._isAMomentObject = true;
    c._useUTC = c._isUTC = isUTC;
    c._l = locale;
    c._i = input;
    c._f = format;
    c._strict = strict;

    return createFromConfig(c);
}

function createLocal (input, format, locale, strict) {
    return createLocalOrUTC(input, format, locale, strict, false);
}

var prototypeMin = deprecate(
    'moment().min is deprecated, use moment.max instead. http://momentjs.com/guides/#/warnings/min-max/',
    function () {
        var other = createLocal.apply(null, arguments);
        if (this.isValid() && other.isValid()) {
            return other < this ? this : other;
        } else {
            return createInvalid();
        }
    }
);

var prototypeMax = deprecate(
    'moment().max is deprecated, use moment.min instead. http://momentjs.com/guides/#/warnings/min-max/',
    function () {
        var other = createLocal.apply(null, arguments);
        if (this.isValid() && other.isValid()) {
            return other > this ? this : other;
        } else {
            return createInvalid();
        }
    }
);

// Pick a moment m from moments so that m[fn](other) is true for all
// other. This relies on the function fn to be transitive.
//
// moments should either be an array of moment objects or an array, whose
// first element is an array of moment objects.
function pickBy(fn, moments) {
    var res, i;
    if (moments.length === 1 && isArray(moments[0])) {
        moments = moments[0];
    }
    if (!moments.length) {
        return createLocal();
    }
    res = moments[0];
    for (i = 1; i < moments.length; ++i) {
        if (!moments[i].isValid() || moments[i][fn](res)) {
            res = moments[i];
        }
    }
    return res;
}

// TODO: Use [].sort instead?
function min () {
    var args = [].slice.call(arguments, 0);

    return pickBy('isBefore', args);
}

function max () {
    var args = [].slice.call(arguments, 0);

    return pickBy('isAfter', args);
}

var now = function () {
    return Date.now ? Date.now() : +(new Date());
};

var ordering = ['year', 'quarter', 'month', 'week', 'day', 'hour', 'minute', 'second', 'millisecond'];

function isDurationValid(m) {
    for (var key in m) {
        if (!(indexOf.call(ordering, key) !== -1 && (m[key] == null || !isNaN(m[key])))) {
            return false;
        }
    }

    var unitHasDecimal = false;
    for (var i = 0; i < ordering.length; ++i) {
        if (m[ordering[i]]) {
            if (unitHasDecimal) {
                return false; // only allow non-integers for smallest unit
            }
            if (parseFloat(m[ordering[i]]) !== toInt(m[ordering[i]])) {
                unitHasDecimal = true;
            }
        }
    }

    return true;
}

function isValid$1() {
    return this._isValid;
}

function createInvalid$1() {
    return createDuration(NaN);
}

function Duration (duration) {
    var normalizedInput = normalizeObjectUnits(duration),
        years = normalizedInput.year || 0,
        quarters = normalizedInput.quarter || 0,
        months = normalizedInput.month || 0,
        weeks = normalizedInput.week || 0,
        days = normalizedInput.day || 0,
        hours = normalizedInput.hour || 0,
        minutes = normalizedInput.minute || 0,
        seconds = normalizedInput.second || 0,
        milliseconds = normalizedInput.millisecond || 0;

    this._isValid = isDurationValid(normalizedInput);

    // representation for dateAddRemove
    this._milliseconds = +milliseconds +
        seconds * 1e3 + // 1000
        minutes * 6e4 + // 1000 * 60
        hours * 1000 * 60 * 60; //using 1000 * 60 * 60 instead of 36e5 to avoid floating point rounding errors https://github.com/moment/moment/issues/2978
    // Because of dateAddRemove treats 24 hours as different from a
    // day when working around DST, we need to store them separately
    this._days = +days +
        weeks * 7;
    // It is impossible to translate months into days without knowing
    // which months you are are talking about, so we have to store
    // it separately.
    this._months = +months +
        quarters * 3 +
        years * 12;

    this._data = {};

    this._locale = getLocale();

    this._bubble();
}

function isDuration (obj) {
    return obj instanceof Duration;
}

function absRound (number) {
    if (number < 0) {
        return Math.round(-1 * number) * -1;
    } else {
        return Math.round(number);
    }
}

// FORMATTING

function offset (token, separator) {
    addFormatToken(token, 0, 0, function () {
        var offset = this.utcOffset();
        var sign = '+';
        if (offset < 0) {
            offset = -offset;
            sign = '-';
        }
        return sign + zeroFill(~~(offset / 60), 2) + separator + zeroFill(~~(offset) % 60, 2);
    });
}

offset('Z', ':');
offset('ZZ', '');

// PARSING

addRegexToken('Z',  matchShortOffset);
addRegexToken('ZZ', matchShortOffset);
addParseToken(['Z', 'ZZ'], function (input, array, config) {
    config._useUTC = true;
    config._tzm = offsetFromString(matchShortOffset, input);
});

// HELPERS

// timezone chunker
// '+10:00' > ['10',  '00']
// '-1530'  > ['-15', '30']
var chunkOffset = /([\+\-]|\d\d)/gi;

function offsetFromString(matcher, string) {
    var matches = (string || '').match(matcher);

    if (matches === null) {
        return null;
    }

    var chunk   = matches[matches.length - 1] || [];
    var parts   = (chunk + '').match(chunkOffset) || ['-', 0, 0];
    var minutes = +(parts[1] * 60) + toInt(parts[2]);

    return minutes === 0 ?
      0 :
      parts[0] === '+' ? minutes : -minutes;
}

// Return a moment from input, that is local/utc/zone equivalent to model.
function cloneWithOffset(input, model) {
    var res, diff;
    if (model._isUTC) {
        res = model.clone();
        diff = (isMoment(input) || isDate(input) ? input.valueOf() : createLocal(input).valueOf()) - res.valueOf();
        // Use low-level api, because this fn is low-level api.
        res._d.setTime(res._d.valueOf() + diff);
        hooks.updateOffset(res, false);
        return res;
    } else {
        return createLocal(input).local();
    }
}

function getDateOffset (m) {
    // On Firefox.24 Date#getTimezoneOffset returns a floating point.
    // https://github.com/moment/moment/pull/1871
    return -Math.round(m._d.getTimezoneOffset() / 15) * 15;
}

// HOOKS

// This function will be called whenever a moment is mutated.
// It is intended to keep the offset in sync with the timezone.
hooks.updateOffset = function () {};

// MOMENTS

// keepLocalTime = true means only change the timezone, without
// affecting the local hour. So 5:31:26 +0300 --[utcOffset(2, true)]-->
// 5:31:26 +0200 It is possible that 5:31:26 doesn't exist with offset
// +0200, so we adjust the time as needed, to be valid.
//
// Keeping the time actually adds/subtracts (one hour)
// from the actual represented time. That is why we call updateOffset
// a second time. In case it wants us to change the offset again
// _changeInProgress == true case, then we have to adjust, because
// there is no such time in the given timezone.
function getSetOffset (input, keepLocalTime, keepMinutes) {
    var offset = this._offset || 0,
        localAdjust;
    if (!this.isValid()) {
        return input != null ? this : NaN;
    }
    if (input != null) {
        if (typeof input === 'string') {
            input = offsetFromString(matchShortOffset, input);
            if (input === null) {
                return this;
            }
        } else if (Math.abs(input) < 16 && !keepMinutes) {
            input = input * 60;
        }
        if (!this._isUTC && keepLocalTime) {
            localAdjust = getDateOffset(this);
        }
        this._offset = input;
        this._isUTC = true;
        if (localAdjust != null) {
            this.add(localAdjust, 'm');
        }
        if (offset !== input) {
            if (!keepLocalTime || this._changeInProgress) {
                addSubtract(this, createDuration(input - offset, 'm'), 1, false);
            } else if (!this._changeInProgress) {
                this._changeInProgress = true;
                hooks.updateOffset(this, true);
                this._changeInProgress = null;
            }
        }
        return this;
    } else {
        return this._isUTC ? offset : getDateOffset(this);
    }
}

function getSetZone (input, keepLocalTime) {
    if (input != null) {
        if (typeof input !== 'string') {
            input = -input;
        }

        this.utcOffset(input, keepLocalTime);

        return this;
    } else {
        return -this.utcOffset();
    }
}

function setOffsetToUTC (keepLocalTime) {
    return this.utcOffset(0, keepLocalTime);
}

function setOffsetToLocal (keepLocalTime) {
    if (this._isUTC) {
        this.utcOffset(0, keepLocalTime);
        this._isUTC = false;

        if (keepLocalTime) {
            this.subtract(getDateOffset(this), 'm');
        }
    }
    return this;
}

function setOffsetToParsedOffset () {
    if (this._tzm != null) {
        this.utcOffset(this._tzm, false, true);
    } else if (typeof this._i === 'string') {
        var tZone = offsetFromString(matchOffset, this._i);
        if (tZone != null) {
            this.utcOffset(tZone);
        }
        else {
            this.utcOffset(0, true);
        }
    }
    return this;
}

function hasAlignedHourOffset (input) {
    if (!this.isValid()) {
        return false;
    }
    input = input ? createLocal(input).utcOffset() : 0;

    return (this.utcOffset() - input) % 60 === 0;
}

function isDaylightSavingTime () {
    return (
        this.utcOffset() > this.clone().month(0).utcOffset() ||
        this.utcOffset() > this.clone().month(5).utcOffset()
    );
}

function isDaylightSavingTimeShifted () {
    if (!isUndefined(this._isDSTShifted)) {
        return this._isDSTShifted;
    }

    var c = {};

    copyConfig(c, this);
    c = prepareConfig(c);

    if (c._a) {
        var other = c._isUTC ? createUTC(c._a) : createLocal(c._a);
        this._isDSTShifted = this.isValid() &&
            compareArrays(c._a, other.toArray()) > 0;
    } else {
        this._isDSTShifted = false;
    }

    return this._isDSTShifted;
}

function isLocal () {
    return this.isValid() ? !this._isUTC : false;
}

function isUtcOffset () {
    return this.isValid() ? this._isUTC : false;
}

function isUtc () {
    return this.isValid() ? this._isUTC && this._offset === 0 : false;
}

// ASP.NET json date format regex
var aspNetRegex = /^(\-|\+)?(?:(\d*)[. ])?(\d+)\:(\d+)(?:\:(\d+)(\.\d*)?)?$/;

// from http://docs.closure-library.googlecode.com/git/closure_goog_date_date.js.source.html
// somewhat more in line with 4.4.3.2 2004 spec, but allows decimal anywhere
// and further modified to allow for strings containing both week and day
var isoRegex = /^(-|\+)?P(?:([-+]?[0-9,.]*)Y)?(?:([-+]?[0-9,.]*)M)?(?:([-+]?[0-9,.]*)W)?(?:([-+]?[0-9,.]*)D)?(?:T(?:([-+]?[0-9,.]*)H)?(?:([-+]?[0-9,.]*)M)?(?:([-+]?[0-9,.]*)S)?)?$/;

function createDuration (input, key) {
    var duration = input,
        // matching against regexp is expensive, do it on demand
        match = null,
        sign,
        ret,
        diffRes;

    if (isDuration(input)) {
        duration = {
            ms : input._milliseconds,
            d  : input._days,
            M  : input._months
        };
    } else if (isNumber(input)) {
        duration = {};
        if (key) {
            duration[key] = input;
        } else {
            duration.milliseconds = input;
        }
    } else if (!!(match = aspNetRegex.exec(input))) {
        sign = (match[1] === '-') ? -1 : 1;
        duration = {
            y  : 0,
            d  : toInt(match[DATE])                         * sign,
            h  : toInt(match[HOUR])                         * sign,
            m  : toInt(match[MINUTE])                       * sign,
            s  : toInt(match[SECOND])                       * sign,
            ms : toInt(absRound(match[MILLISECOND] * 1000)) * sign // the millisecond decimal point is included in the match
        };
    } else if (!!(match = isoRegex.exec(input))) {
        sign = (match[1] === '-') ? -1 : (match[1] === '+') ? 1 : 1;
        duration = {
            y : parseIso(match[2], sign),
            M : parseIso(match[3], sign),
            w : parseIso(match[4], sign),
            d : parseIso(match[5], sign),
            h : parseIso(match[6], sign),
            m : parseIso(match[7], sign),
            s : parseIso(match[8], sign)
        };
    } else if (duration == null) {// checks for null or undefined
        duration = {};
    } else if (typeof duration === 'object' && ('from' in duration || 'to' in duration)) {
        diffRes = momentsDifference(createLocal(duration.from), createLocal(duration.to));

        duration = {};
        duration.ms = diffRes.milliseconds;
        duration.M = diffRes.months;
    }

    ret = new Duration(duration);

    if (isDuration(input) && hasOwnProp(input, '_locale')) {
        ret._locale = input._locale;
    }

    return ret;
}

createDuration.fn = Duration.prototype;
createDuration.invalid = createInvalid$1;

function parseIso (inp, sign) {
    // We'd normally use ~~inp for this, but unfortunately it also
    // converts floats to ints.
    // inp may be undefined, so careful calling replace on it.
    var res = inp && parseFloat(inp.replace(',', '.'));
    // apply sign while we're at it
    return (isNaN(res) ? 0 : res) * sign;
}

function positiveMomentsDifference(base, other) {
    var res = {milliseconds: 0, months: 0};

    res.months = other.month() - base.month() +
        (other.year() - base.year()) * 12;
    if (base.clone().add(res.months, 'M').isAfter(other)) {
        --res.months;
    }

    res.milliseconds = +other - +(base.clone().add(res.months, 'M'));

    return res;
}

function momentsDifference(base, other) {
    var res;
    if (!(base.isValid() && other.isValid())) {
        return {milliseconds: 0, months: 0};
    }

    other = cloneWithOffset(other, base);
    if (base.isBefore(other)) {
        res = positiveMomentsDifference(base, other);
    } else {
        res = positiveMomentsDifference(other, base);
        res.milliseconds = -res.milliseconds;
        res.months = -res.months;
    }

    return res;
}

// TODO: remove 'name' arg after deprecation is removed
function createAdder(direction, name) {
    return function (val, period) {
        var dur, tmp;
        //invert the arguments, but complain about it
        if (period !== null && !isNaN(+period)) {
            deprecateSimple(name, 'moment().' + name  + '(period, number) is deprecated. Please use moment().' + name + '(number, period). ' +
            'See http://momentjs.com/guides/#/warnings/add-inverted-param/ for more info.');
            tmp = val; val = period; period = tmp;
        }

        val = typeof val === 'string' ? +val : val;
        dur = createDuration(val, period);
        addSubtract(this, dur, direction);
        return this;
    };
}

function addSubtract (mom, duration, isAdding, updateOffset) {
    var milliseconds = duration._milliseconds,
        days = absRound(duration._days),
        months = absRound(duration._months);

    if (!mom.isValid()) {
        // No op
        return;
    }

    updateOffset = updateOffset == null ? true : updateOffset;

    if (months) {
        setMonth(mom, get(mom, 'Month') + months * isAdding);
    }
    if (days) {
        set$1(mom, 'Date', get(mom, 'Date') + days * isAdding);
    }
    if (milliseconds) {
        mom._d.setTime(mom._d.valueOf() + milliseconds * isAdding);
    }
    if (updateOffset) {
        hooks.updateOffset(mom, days || months);
    }
}

var add      = createAdder(1, 'add');
var subtract = createAdder(-1, 'subtract');

function getCalendarFormat(myMoment, now) {
    var diff = myMoment.diff(now, 'days', true);
    return diff < -6 ? 'sameElse' :
            diff < -1 ? 'lastWeek' :
            diff < 0 ? 'lastDay' :
            diff < 1 ? 'sameDay' :
            diff < 2 ? 'nextDay' :
            diff < 7 ? 'nextWeek' : 'sameElse';
}

function calendar$1 (time, formats) {
    // We want to compare the start of today, vs this.
    // Getting start-of-today depends on whether we're local/utc/offset or not.
    var now = time || createLocal(),
        sod = cloneWithOffset(now, this).startOf('day'),
        format = hooks.calendarFormat(this, sod) || 'sameElse';

    var output = formats && (isFunction(formats[format]) ? formats[format].call(this, now) : formats[format]);

    return this.format(output || this.localeData().calendar(format, this, createLocal(now)));
}

function clone () {
    return new Moment(this);
}

function isAfter (input, units) {
    var localInput = isMoment(input) ? input : createLocal(input);
    if (!(this.isValid() && localInput.isValid())) {
        return false;
    }
    units = normalizeUnits(!isUndefined(units) ? units : 'millisecond');
    if (units === 'millisecond') {
        return this.valueOf() > localInput.valueOf();
    } else {
        return localInput.valueOf() < this.clone().startOf(units).valueOf();
    }
}

function isBefore (input, units) {
    var localInput = isMoment(input) ? input : createLocal(input);
    if (!(this.isValid() && localInput.isValid())) {
        return false;
    }
    units = normalizeUnits(!isUndefined(units) ? units : 'millisecond');
    if (units === 'millisecond') {
        return this.valueOf() < localInput.valueOf();
    } else {
        return this.clone().endOf(units).valueOf() < localInput.valueOf();
    }
}

function isBetween (from, to, units, inclusivity) {
    inclusivity = inclusivity || '()';
    return (inclusivity[0] === '(' ? this.isAfter(from, units) : !this.isBefore(from, units)) &&
        (inclusivity[1] === ')' ? this.isBefore(to, units) : !this.isAfter(to, units));
}

function isSame (input, units) {
    var localInput = isMoment(input) ? input : createLocal(input),
        inputMs;
    if (!(this.isValid() && localInput.isValid())) {
        return false;
    }
    units = normalizeUnits(units || 'millisecond');
    if (units === 'millisecond') {
        return this.valueOf() === localInput.valueOf();
    } else {
        inputMs = localInput.valueOf();
        return this.clone().startOf(units).valueOf() <= inputMs && inputMs <= this.clone().endOf(units).valueOf();
    }
}

function isSameOrAfter (input, units) {
    return this.isSame(input, units) || this.isAfter(input,units);
}

function isSameOrBefore (input, units) {
    return this.isSame(input, units) || this.isBefore(input,units);
}

function diff (input, units, asFloat) {
    var that,
        zoneDelta,
        delta, output;

    if (!this.isValid()) {
        return NaN;
    }

    that = cloneWithOffset(input, this);

    if (!that.isValid()) {
        return NaN;
    }

    zoneDelta = (that.utcOffset() - this.utcOffset()) * 6e4;

    units = normalizeUnits(units);

    switch (units) {
        case 'year': output = monthDiff(this, that) / 12; break;
        case 'month': output = monthDiff(this, that); break;
        case 'quarter': output = monthDiff(this, that) / 3; break;
        case 'second': output = (this - that) / 1e3; break; // 1000
        case 'minute': output = (this - that) / 6e4; break; // 1000 * 60
        case 'hour': output = (this - that) / 36e5; break; // 1000 * 60 * 60
        case 'day': output = (this - that - zoneDelta) / 864e5; break; // 1000 * 60 * 60 * 24, negate dst
        case 'week': output = (this - that - zoneDelta) / 6048e5; break; // 1000 * 60 * 60 * 24 * 7, negate dst
        default: output = this - that;
    }

    return asFloat ? output : absFloor(output);
}

function monthDiff (a, b) {
    // difference in months
    var wholeMonthDiff = ((b.year() - a.year()) * 12) + (b.month() - a.month()),
        // b is in (anchor - 1 month, anchor + 1 month)
        anchor = a.clone().add(wholeMonthDiff, 'months'),
        anchor2, adjust;

    if (b - anchor < 0) {
        anchor2 = a.clone().add(wholeMonthDiff - 1, 'months');
        // linear across the month
        adjust = (b - anchor) / (anchor - anchor2);
    } else {
        anchor2 = a.clone().add(wholeMonthDiff + 1, 'months');
        // linear across the month
        adjust = (b - anchor) / (anchor2 - anchor);
    }

    //check for negative zero, return zero if negative zero
    return -(wholeMonthDiff + adjust) || 0;
}

hooks.defaultFormat = 'YYYY-MM-DDTHH:mm:ssZ';
hooks.defaultFormatUtc = 'YYYY-MM-DDTHH:mm:ss[Z]';

function toString () {
    return this.clone().locale('en').format('ddd MMM DD YYYY HH:mm:ss [GMT]ZZ');
}

function toISOString() {
    if (!this.isValid()) {
        return null;
    }
    var m = this.clone().utc();
    if (m.year() < 0 || m.year() > 9999) {
        return formatMoment(m, 'YYYYYY-MM-DD[T]HH:mm:ss.SSS[Z]');
    }
    if (isFunction(Date.prototype.toISOString)) {
        // native implementation is ~50x faster, use it when we can
        return this.toDate().toISOString();
    }
    return formatMoment(m, 'YYYY-MM-DD[T]HH:mm:ss.SSS[Z]');
}

/**
 * Return a human readable representation of a moment that can
 * also be evaluated to get a new moment which is the same
 *
 * @link https://nodejs.org/dist/latest/docs/api/util.html#util_custom_inspect_function_on_objects
 */
function inspect () {
    if (!this.isValid()) {
        return 'moment.invalid(/* ' + this._i + ' */)';
    }
    var func = 'moment';
    var zone = '';
    if (!this.isLocal()) {
        func = this.utcOffset() === 0 ? 'moment.utc' : 'moment.parseZone';
        zone = 'Z';
    }
    var prefix = '[' + func + '("]';
    var year = (0 <= this.year() && this.year() <= 9999) ? 'YYYY' : 'YYYYYY';
    var datetime = '-MM-DD[T]HH:mm:ss.SSS';
    var suffix = zone + '[")]';

    return this.format(prefix + year + datetime + suffix);
}

function format (inputString) {
    if (!inputString) {
        inputString = this.isUtc() ? hooks.defaultFormatUtc : hooks.defaultFormat;
    }
    var output = formatMoment(this, inputString);
    return this.localeData().postformat(output);
}

function from (time, withoutSuffix) {
    if (this.isValid() &&
            ((isMoment(time) && time.isValid()) ||
             createLocal(time).isValid())) {
        return createDuration({to: this, from: time}).locale(this.locale()).humanize(!withoutSuffix);
    } else {
        return this.localeData().invalidDate();
    }
}

function fromNow (withoutSuffix) {
    return this.from(createLocal(), withoutSuffix);
}

function to (time, withoutSuffix) {
    if (this.isValid() &&
            ((isMoment(time) && time.isValid()) ||
             createLocal(time).isValid())) {
        return createDuration({from: this, to: time}).locale(this.locale()).humanize(!withoutSuffix);
    } else {
        return this.localeData().invalidDate();
    }
}

function toNow (withoutSuffix) {
    return this.to(createLocal(), withoutSuffix);
}

// If passed a locale key, it will set the locale for this
// instance.  Otherwise, it will return the locale configuration
// variables for this instance.
function locale (key) {
    var newLocaleData;

    if (key === undefined) {
        return this._locale._abbr;
    } else {
        newLocaleData = getLocale(key);
        if (newLocaleData != null) {
            this._locale = newLocaleData;
        }
        return this;
    }
}

var lang = deprecate(
    'moment().lang() is deprecated. Instead, use moment().localeData() to get the language configuration. Use moment().locale() to change languages.',
    function (key) {
        if (key === undefined) {
            return this.localeData();
        } else {
            return this.locale(key);
        }
    }
);

function localeData () {
    return this._locale;
}

function startOf (units) {
    units = normalizeUnits(units);
    // the following switch intentionally omits break keywords
    // to utilize falling through the cases.
    switch (units) {
        case 'year':
            this.month(0);
            /* falls through */
        case 'quarter':
        case 'month':
            this.date(1);
            /* falls through */
        case 'week':
        case 'isoWeek':
        case 'day':
        case 'date':
            this.hours(0);
            /* falls through */
        case 'hour':
            this.minutes(0);
            /* falls through */
        case 'minute':
            this.seconds(0);
            /* falls through */
        case 'second':
            this.milliseconds(0);
    }

    // weeks are a special case
    if (units === 'week') {
        this.weekday(0);
    }
    if (units === 'isoWeek') {
        this.isoWeekday(1);
    }

    // quarters are also special
    if (units === 'quarter') {
        this.month(Math.floor(this.month() / 3) * 3);
    }

    return this;
}

function endOf (units) {
    units = normalizeUnits(units);
    if (units === undefined || units === 'millisecond') {
        return this;
    }

    // 'date' is an alias for 'day', so it should be considered as such.
    if (units === 'date') {
        units = 'day';
    }

    return this.startOf(units).add(1, (units === 'isoWeek' ? 'week' : units)).subtract(1, 'ms');
}

function valueOf () {
    return this._d.valueOf() - ((this._offset || 0) * 60000);
}

function unix () {
    return Math.floor(this.valueOf() / 1000);
}

function toDate () {
    return new Date(this.valueOf());
}

function toArray () {
    var m = this;
    return [m.year(), m.month(), m.date(), m.hour(), m.minute(), m.second(), m.millisecond()];
}

function toObject () {
    var m = this;
    return {
        years: m.year(),
        months: m.month(),
        date: m.date(),
        hours: m.hours(),
        minutes: m.minutes(),
        seconds: m.seconds(),
        milliseconds: m.milliseconds()
    };
}

function toJSON () {
    // new Date(NaN).toJSON() === null
    return this.isValid() ? this.toISOString() : null;
}

function isValid$2 () {
    return isValid(this);
}

function parsingFlags () {
    return extend({}, getParsingFlags(this));
}

function invalidAt () {
    return getParsingFlags(this).overflow;
}

function creationData() {
    return {
        input: this._i,
        format: this._f,
        locale: this._locale,
        isUTC: this._isUTC,
        strict: this._strict
    };
}

// FORMATTING

addFormatToken(0, ['gg', 2], 0, function () {
    return this.weekYear() % 100;
});

addFormatToken(0, ['GG', 2], 0, function () {
    return this.isoWeekYear() % 100;
});

function addWeekYearFormatToken (token, getter) {
    addFormatToken(0, [token, token.length], 0, getter);
}

addWeekYearFormatToken('gggg',     'weekYear');
addWeekYearFormatToken('ggggg',    'weekYear');
addWeekYearFormatToken('GGGG',  'isoWeekYear');
addWeekYearFormatToken('GGGGG', 'isoWeekYear');

// ALIASES

addUnitAlias('weekYear', 'gg');
addUnitAlias('isoWeekYear', 'GG');

// PRIORITY

addUnitPriority('weekYear', 1);
addUnitPriority('isoWeekYear', 1);


// PARSING

addRegexToken('G',      matchSigned);
addRegexToken('g',      matchSigned);
addRegexToken('GG',     match1to2, match2);
addRegexToken('gg',     match1to2, match2);
addRegexToken('GGGG',   match1to4, match4);
addRegexToken('gggg',   match1to4, match4);
addRegexToken('GGGGG',  match1to6, match6);
addRegexToken('ggggg',  match1to6, match6);

addWeekParseToken(['gggg', 'ggggg', 'GGGG', 'GGGGG'], function (input, week, config, token) {
    week[token.substr(0, 2)] = toInt(input);
});

addWeekParseToken(['gg', 'GG'], function (input, week, config, token) {
    week[token] = hooks.parseTwoDigitYear(input);
});

// MOMENTS

function getSetWeekYear (input) {
    return getSetWeekYearHelper.call(this,
            input,
            this.week(),
            this.weekday(),
            this.localeData()._week.dow,
            this.localeData()._week.doy);
}

function getSetISOWeekYear (input) {
    return getSetWeekYearHelper.call(this,
            input, this.isoWeek(), this.isoWeekday(), 1, 4);
}

function getISOWeeksInYear () {
    return weeksInYear(this.year(), 1, 4);
}

function getWeeksInYear () {
    var weekInfo = this.localeData()._week;
    return weeksInYear(this.year(), weekInfo.dow, weekInfo.doy);
}

function getSetWeekYearHelper(input, week, weekday, dow, doy) {
    var weeksTarget;
    if (input == null) {
        return weekOfYear(this, dow, doy).year;
    } else {
        weeksTarget = weeksInYear(input, dow, doy);
        if (week > weeksTarget) {
            week = weeksTarget;
        }
        return setWeekAll.call(this, input, week, weekday, dow, doy);
    }
}

function setWeekAll(weekYear, week, weekday, dow, doy) {
    var dayOfYearData = dayOfYearFromWeeks(weekYear, week, weekday, dow, doy),
        date = createUTCDate(dayOfYearData.year, 0, dayOfYearData.dayOfYear);

    this.year(date.getUTCFullYear());
    this.month(date.getUTCMonth());
    this.date(date.getUTCDate());
    return this;
}

// FORMATTING

addFormatToken('Q', 0, 'Qo', 'quarter');

// ALIASES

addUnitAlias('quarter', 'Q');

// PRIORITY

addUnitPriority('quarter', 7);

// PARSING

addRegexToken('Q', match1);
addParseToken('Q', function (input, array) {
    array[MONTH] = (toInt(input) - 1) * 3;
});

// MOMENTS

function getSetQuarter (input) {
    return input == null ? Math.ceil((this.month() + 1) / 3) : this.month((input - 1) * 3 + this.month() % 3);
}

// FORMATTING

addFormatToken('D', ['DD', 2], 'Do', 'date');

// ALIASES

addUnitAlias('date', 'D');

// PRIOROITY
addUnitPriority('date', 9);

// PARSING

addRegexToken('D',  match1to2);
addRegexToken('DD', match1to2, match2);
addRegexToken('Do', function (isStrict, locale) {
    // TODO: Remove "ordinalParse" fallback in next major release.
    return isStrict ?
      (locale._dayOfMonthOrdinalParse || locale._ordinalParse) :
      locale._dayOfMonthOrdinalParseLenient;
});

addParseToken(['D', 'DD'], DATE);
addParseToken('Do', function (input, array) {
    array[DATE] = toInt(input.match(match1to2)[0], 10);
});

// MOMENTS

var getSetDayOfMonth = makeGetSet('Date', true);

// FORMATTING

addFormatToken('DDD', ['DDDD', 3], 'DDDo', 'dayOfYear');

// ALIASES

addUnitAlias('dayOfYear', 'DDD');

// PRIORITY
addUnitPriority('dayOfYear', 4);

// PARSING

addRegexToken('DDD',  match1to3);
addRegexToken('DDDD', match3);
addParseToken(['DDD', 'DDDD'], function (input, array, config) {
    config._dayOfYear = toInt(input);
});

// HELPERS

// MOMENTS

function getSetDayOfYear (input) {
    var dayOfYear = Math.round((this.clone().startOf('day') - this.clone().startOf('year')) / 864e5) + 1;
    return input == null ? dayOfYear : this.add((input - dayOfYear), 'd');
}

// FORMATTING

addFormatToken('m', ['mm', 2], 0, 'minute');

// ALIASES

addUnitAlias('minute', 'm');

// PRIORITY

addUnitPriority('minute', 14);

// PARSING

addRegexToken('m',  match1to2);
addRegexToken('mm', match1to2, match2);
addParseToken(['m', 'mm'], MINUTE);

// MOMENTS

var getSetMinute = makeGetSet('Minutes', false);

// FORMATTING

addFormatToken('s', ['ss', 2], 0, 'second');

// ALIASES

addUnitAlias('second', 's');

// PRIORITY

addUnitPriority('second', 15);

// PARSING

addRegexToken('s',  match1to2);
addRegexToken('ss', match1to2, match2);
addParseToken(['s', 'ss'], SECOND);

// MOMENTS

var getSetSecond = makeGetSet('Seconds', false);

// FORMATTING

addFormatToken('S', 0, 0, function () {
    return ~~(this.millisecond() / 100);
});

addFormatToken(0, ['SS', 2], 0, function () {
    return ~~(this.millisecond() / 10);
});

addFormatToken(0, ['SSS', 3], 0, 'millisecond');
addFormatToken(0, ['SSSS', 4], 0, function () {
    return this.millisecond() * 10;
});
addFormatToken(0, ['SSSSS', 5], 0, function () {
    return this.millisecond() * 100;
});
addFormatToken(0, ['SSSSSS', 6], 0, function () {
    return this.millisecond() * 1000;
});
addFormatToken(0, ['SSSSSSS', 7], 0, function () {
    return this.millisecond() * 10000;
});
addFormatToken(0, ['SSSSSSSS', 8], 0, function () {
    return this.millisecond() * 100000;
});
addFormatToken(0, ['SSSSSSSSS', 9], 0, function () {
    return this.millisecond() * 1000000;
});


// ALIASES

addUnitAlias('millisecond', 'ms');

// PRIORITY

addUnitPriority('millisecond', 16);

// PARSING

addRegexToken('S',    match1to3, match1);
addRegexToken('SS',   match1to3, match2);
addRegexToken('SSS',  match1to3, match3);

var token;
for (token = 'SSSS'; token.length <= 9; token += 'S') {
    addRegexToken(token, matchUnsigned);
}

function parseMs(input, array) {
    array[MILLISECOND] = toInt(('0.' + input) * 1000);
}

for (token = 'S'; token.length <= 9; token += 'S') {
    addParseToken(token, parseMs);
}
// MOMENTS

var getSetMillisecond = makeGetSet('Milliseconds', false);

// FORMATTING

addFormatToken('z',  0, 0, 'zoneAbbr');
addFormatToken('zz', 0, 0, 'zoneName');

// MOMENTS

function getZoneAbbr () {
    return this._isUTC ? 'UTC' : '';
}

function getZoneName () {
    return this._isUTC ? 'Coordinated Universal Time' : '';
}

var proto = Moment.prototype;

proto.add               = add;
proto.calendar          = calendar$1;
proto.clone             = clone;
proto.diff              = diff;
proto.endOf             = endOf;
proto.format            = format;
proto.from              = from;
proto.fromNow           = fromNow;
proto.to                = to;
proto.toNow             = toNow;
proto.get               = stringGet;
proto.invalidAt         = invalidAt;
proto.isAfter           = isAfter;
proto.isBefore          = isBefore;
proto.isBetween         = isBetween;
proto.isSame            = isSame;
proto.isSameOrAfter     = isSameOrAfter;
proto.isSameOrBefore    = isSameOrBefore;
proto.isValid           = isValid$2;
proto.lang              = lang;
proto.locale            = locale;
proto.localeData        = localeData;
proto.max               = prototypeMax;
proto.min               = prototypeMin;
proto.parsingFlags      = parsingFlags;
proto.set               = stringSet;
proto.startOf           = startOf;
proto.subtract          = subtract;
proto.toArray           = toArray;
proto.toObject          = toObject;
proto.toDate            = toDate;
proto.toISOString       = toISOString;
proto.inspect           = inspect;
proto.toJSON            = toJSON;
proto.toString          = toString;
proto.unix              = unix;
proto.valueOf           = valueOf;
proto.creationData      = creationData;

// Year
proto.year       = getSetYear;
proto.isLeapYear = getIsLeapYear;

// Week Year
proto.weekYear    = getSetWeekYear;
proto.isoWeekYear = getSetISOWeekYear;

// Quarter
proto.quarter = proto.quarters = getSetQuarter;

// Month
proto.month       = getSetMonth;
proto.daysInMonth = getDaysInMonth;

// Week
proto.week           = proto.weeks        = getSetWeek;
proto.isoWeek        = proto.isoWeeks     = getSetISOWeek;
proto.weeksInYear    = getWeeksInYear;
proto.isoWeeksInYear = getISOWeeksInYear;

// Day
proto.date       = getSetDayOfMonth;
proto.day        = proto.days             = getSetDayOfWeek;
proto.weekday    = getSetLocaleDayOfWeek;
proto.isoWeekday = getSetISODayOfWeek;
proto.dayOfYear  = getSetDayOfYear;

// Hour
proto.hour = proto.hours = getSetHour;

// Minute
proto.minute = proto.minutes = getSetMinute;

// Second
proto.second = proto.seconds = getSetSecond;

// Millisecond
proto.millisecond = proto.milliseconds = getSetMillisecond;

// Offset
proto.utcOffset            = getSetOffset;
proto.utc                  = setOffsetToUTC;
proto.local                = setOffsetToLocal;
proto.parseZone            = setOffsetToParsedOffset;
proto.hasAlignedHourOffset = hasAlignedHourOffset;
proto.isDST                = isDaylightSavingTime;
proto.isLocal              = isLocal;
proto.isUtcOffset          = isUtcOffset;
proto.isUtc                = isUtc;
proto.isUTC                = isUtc;

// Timezone
proto.zoneAbbr = getZoneAbbr;
proto.zoneName = getZoneName;

// Deprecations
proto.dates  = deprecate('dates accessor is deprecated. Use date instead.', getSetDayOfMonth);
proto.months = deprecate('months accessor is deprecated. Use month instead', getSetMonth);
proto.years  = deprecate('years accessor is deprecated. Use year instead', getSetYear);
proto.zone   = deprecate('moment().zone is deprecated, use moment().utcOffset instead. http://momentjs.com/guides/#/warnings/zone/', getSetZone);
proto.isDSTShifted = deprecate('isDSTShifted is deprecated. See http://momentjs.com/guides/#/warnings/dst-shifted/ for more information', isDaylightSavingTimeShifted);

function createUnix (input) {
    return createLocal(input * 1000);
}

function createInZone () {
    return createLocal.apply(null, arguments).parseZone();
}

function preParsePostFormat (string) {
    return string;
}

var proto$1 = Locale.prototype;

proto$1.calendar        = calendar;
proto$1.longDateFormat  = longDateFormat;
proto$1.invalidDate     = invalidDate;
proto$1.ordinal         = ordinal;
proto$1.preparse        = preParsePostFormat;
proto$1.postformat      = preParsePostFormat;
proto$1.relativeTime    = relativeTime;
proto$1.pastFuture      = pastFuture;
proto$1.set             = set;

// Month
proto$1.months            =        localeMonths;
proto$1.monthsShort       =        localeMonthsShort;
proto$1.monthsParse       =        localeMonthsParse;
proto$1.monthsRegex       = monthsRegex;
proto$1.monthsShortRegex  = monthsShortRegex;

// Week
proto$1.week = localeWeek;
proto$1.firstDayOfYear = localeFirstDayOfYear;
proto$1.firstDayOfWeek = localeFirstDayOfWeek;

// Day of Week
proto$1.weekdays       =        localeWeekdays;
proto$1.weekdaysMin    =        localeWeekdaysMin;
proto$1.weekdaysShort  =        localeWeekdaysShort;
proto$1.weekdaysParse  =        localeWeekdaysParse;

proto$1.weekdaysRegex       =        weekdaysRegex;
proto$1.weekdaysShortRegex  =        weekdaysShortRegex;
proto$1.weekdaysMinRegex    =        weekdaysMinRegex;

// Hours
proto$1.isPM = localeIsPM;
proto$1.meridiem = localeMeridiem;

function get$1 (format, index, field, setter) {
    var locale = getLocale();
    var utc = createUTC().set(setter, index);
    return locale[field](utc, format);
}

function listMonthsImpl (format, index, field) {
    if (isNumber(format)) {
        index = format;
        format = undefined;
    }

    format = format || '';

    if (index != null) {
        return get$1(format, index, field, 'month');
    }

    var i;
    var out = [];
    for (i = 0; i < 12; i++) {
        out[i] = get$1(format, i, field, 'month');
    }
    return out;
}

// ()
// (5)
// (fmt, 5)
// (fmt)
// (true)
// (true, 5)
// (true, fmt, 5)
// (true, fmt)
function listWeekdaysImpl (localeSorted, format, index, field) {
    if (typeof localeSorted === 'boolean') {
        if (isNumber(format)) {
            index = format;
            format = undefined;
        }

        format = format || '';
    } else {
        format = localeSorted;
        index = format;
        localeSorted = false;

        if (isNumber(format)) {
            index = format;
            format = undefined;
        }

        format = format || '';
    }

    var locale = getLocale(),
        shift = localeSorted ? locale._week.dow : 0;

    if (index != null) {
        return get$1(format, (index + shift) % 7, field, 'day');
    }

    var i;
    var out = [];
    for (i = 0; i < 7; i++) {
        out[i] = get$1(format, (i + shift) % 7, field, 'day');
    }
    return out;
}

function listMonths (format, index) {
    return listMonthsImpl(format, index, 'months');
}

function listMonthsShort (format, index) {
    return listMonthsImpl(format, index, 'monthsShort');
}

function listWeekdays (localeSorted, format, index) {
    return listWeekdaysImpl(localeSorted, format, index, 'weekdays');
}

function listWeekdaysShort (localeSorted, format, index) {
    return listWeekdaysImpl(localeSorted, format, index, 'weekdaysShort');
}

function listWeekdaysMin (localeSorted, format, index) {
    return listWeekdaysImpl(localeSorted, format, index, 'weekdaysMin');
}

getSetGlobalLocale('en', {
    dayOfMonthOrdinalParse: /\d{1,2}(th|st|nd|rd)/,
    ordinal : function (number) {
        var b = number % 10,
            output = (toInt(number % 100 / 10) === 1) ? 'th' :
            (b === 1) ? 'st' :
            (b === 2) ? 'nd' :
            (b === 3) ? 'rd' : 'th';
        return number + output;
    }
});

// Side effect imports
hooks.lang = deprecate('moment.lang is deprecated. Use moment.locale instead.', getSetGlobalLocale);
hooks.langData = deprecate('moment.langData is deprecated. Use moment.localeData instead.', getLocale);

var mathAbs = Math.abs;

function abs () {
    var data           = this._data;

    this._milliseconds = mathAbs(this._milliseconds);
    this._days         = mathAbs(this._days);
    this._months       = mathAbs(this._months);

    data.milliseconds  = mathAbs(data.milliseconds);
    data.seconds       = mathAbs(data.seconds);
    data.minutes       = mathAbs(data.minutes);
    data.hours         = mathAbs(data.hours);
    data.months        = mathAbs(data.months);
    data.years         = mathAbs(data.years);

    return this;
}

function addSubtract$1 (duration, input, value, direction) {
    var other = createDuration(input, value);

    duration._milliseconds += direction * other._milliseconds;
    duration._days         += direction * other._days;
    duration._months       += direction * other._months;

    return duration._bubble();
}

// supports only 2.0-style add(1, 's') or add(duration)
function add$1 (input, value) {
    return addSubtract$1(this, input, value, 1);
}

// supports only 2.0-style subtract(1, 's') or subtract(duration)
function subtract$1 (input, value) {
    return addSubtract$1(this, input, value, -1);
}

function absCeil (number) {
    if (number < 0) {
        return Math.floor(number);
    } else {
        return Math.ceil(number);
    }
}

function bubble () {
    var milliseconds = this._milliseconds;
    var days         = this._days;
    var months       = this._months;
    var data         = this._data;
    var seconds, minutes, hours, years, monthsFromDays;

    // if we have a mix of positive and negative values, bubble down first
    // check: https://github.com/moment/moment/issues/2166
    if (!((milliseconds >= 0 && days >= 0 && months >= 0) ||
            (milliseconds <= 0 && days <= 0 && months <= 0))) {
        milliseconds += absCeil(monthsToDays(months) + days) * 864e5;
        days = 0;
        months = 0;
    }

    // The following code bubbles up values, see the tests for
    // examples of what that means.
    data.milliseconds = milliseconds % 1000;

    seconds           = absFloor(milliseconds / 1000);
    data.seconds      = seconds % 60;

    minutes           = absFloor(seconds / 60);
    data.minutes      = minutes % 60;

    hours             = absFloor(minutes / 60);
    data.hours        = hours % 24;

    days += absFloor(hours / 24);

    // convert days to months
    monthsFromDays = absFloor(daysToMonths(days));
    months += monthsFromDays;
    days -= absCeil(monthsToDays(monthsFromDays));

    // 12 months -> 1 year
    years = absFloor(months / 12);
    months %= 12;

    data.days   = days;
    data.months = months;
    data.years  = years;

    return this;
}

function daysToMonths (days) {
    // 400 years have 146097 days (taking into account leap year rules)
    // 400 years have 12 months === 4800
    return days * 4800 / 146097;
}

function monthsToDays (months) {
    // the reverse of daysToMonths
    return months * 146097 / 4800;
}

function as (units) {
    if (!this.isValid()) {
        return NaN;
    }
    var days;
    var months;
    var milliseconds = this._milliseconds;

    units = normalizeUnits(units);

    if (units === 'month' || units === 'year') {
        days   = this._days   + milliseconds / 864e5;
        months = this._months + daysToMonths(days);
        return units === 'month' ? months : months / 12;
    } else {
        // handle milliseconds separately because of floating point math errors (issue #1867)
        days = this._days + Math.round(monthsToDays(this._months));
        switch (units) {
            case 'week'   : return days / 7     + milliseconds / 6048e5;
            case 'day'    : return days         + milliseconds / 864e5;
            case 'hour'   : return days * 24    + milliseconds / 36e5;
            case 'minute' : return days * 1440  + milliseconds / 6e4;
            case 'second' : return days * 86400 + milliseconds / 1000;
            // Math.floor prevents floating point math errors here
            case 'millisecond': return Math.floor(days * 864e5) + milliseconds;
            default: throw new Error('Unknown unit ' + units);
        }
    }
}

// TODO: Use this.as('ms')?
function valueOf$1 () {
    if (!this.isValid()) {
        return NaN;
    }
    return (
        this._milliseconds +
        this._days * 864e5 +
        (this._months % 12) * 2592e6 +
        toInt(this._months / 12) * 31536e6
    );
}

function makeAs (alias) {
    return function () {
        return this.as(alias);
    };
}

var asMilliseconds = makeAs('ms');
var asSeconds      = makeAs('s');
var asMinutes      = makeAs('m');
var asHours        = makeAs('h');
var asDays         = makeAs('d');
var asWeeks        = makeAs('w');
var asMonths       = makeAs('M');
var asYears        = makeAs('y');

function clone$1 () {
    return createDuration(this);
}

function get$2 (units) {
    units = normalizeUnits(units);
    return this.isValid() ? this[units + 's']() : NaN;
}

function makeGetter(name) {
    return function () {
        return this.isValid() ? this._data[name] : NaN;
    };
}

var milliseconds = makeGetter('milliseconds');
var seconds      = makeGetter('seconds');
var minutes      = makeGetter('minutes');
var hours        = makeGetter('hours');
var days         = makeGetter('days');
var months       = makeGetter('months');
var years        = makeGetter('years');

function weeks () {
    return absFloor(this.days() / 7);
}

var round = Math.round;
var thresholds = {
    ss: 44,         // a few seconds to seconds
    s : 45,         // seconds to minute
    m : 45,         // minutes to hour
    h : 22,         // hours to day
    d : 26,         // days to month
    M : 11          // months to year
};

// helper function for moment.fn.from, moment.fn.fromNow, and moment.duration.fn.humanize
function substituteTimeAgo(string, number, withoutSuffix, isFuture, locale) {
    return locale.relativeTime(number || 1, !!withoutSuffix, string, isFuture);
}

function relativeTime$1 (posNegDuration, withoutSuffix, locale) {
    var duration = createDuration(posNegDuration).abs();
    var seconds  = round(duration.as('s'));
    var minutes  = round(duration.as('m'));
    var hours    = round(duration.as('h'));
    var days     = round(duration.as('d'));
    var months   = round(duration.as('M'));
    var years    = round(duration.as('y'));

    var a = seconds <= thresholds.ss && ['s', seconds]  ||
            seconds < thresholds.s   && ['ss', seconds] ||
            minutes <= 1             && ['m']           ||
            minutes < thresholds.m   && ['mm', minutes] ||
            hours   <= 1             && ['h']           ||
            hours   < thresholds.h   && ['hh', hours]   ||
            days    <= 1             && ['d']           ||
            days    < thresholds.d   && ['dd', days]    ||
            months  <= 1             && ['M']           ||
            months  < thresholds.M   && ['MM', months]  ||
            years   <= 1             && ['y']           || ['yy', years];

    a[2] = withoutSuffix;
    a[3] = +posNegDuration > 0;
    a[4] = locale;
    return substituteTimeAgo.apply(null, a);
}

// This function allows you to set the rounding function for relative time strings
function getSetRelativeTimeRounding (roundingFunction) {
    if (roundingFunction === undefined) {
        return round;
    }
    if (typeof(roundingFunction) === 'function') {
        round = roundingFunction;
        return true;
    }
    return false;
}

// This function allows you to set a threshold for relative time strings
function getSetRelativeTimeThreshold (threshold, limit) {
    if (thresholds[threshold] === undefined) {
        return false;
    }
    if (limit === undefined) {
        return thresholds[threshold];
    }
    thresholds[threshold] = limit;
    if (threshold === 's') {
        thresholds.ss = limit - 1;
    }
    return true;
}

function humanize (withSuffix) {
    if (!this.isValid()) {
        return this.localeData().invalidDate();
    }

    var locale = this.localeData();
    var output = relativeTime$1(this, !withSuffix, locale);

    if (withSuffix) {
        output = locale.pastFuture(+this, output);
    }

    return locale.postformat(output);
}

var abs$1 = Math.abs;

function sign(x) {
    return ((x > 0) - (x < 0)) || +x;
}

function toISOString$1() {
    // for ISO strings we do not use the normal bubbling rules:
    //  * milliseconds bubble up until they become hours
    //  * days do not bubble at all
    //  * months bubble up until they become years
    // This is because there is no context-free conversion between hours and days
    // (think of clock changes)
    // and also not between days and months (28-31 days per month)
    if (!this.isValid()) {
        return this.localeData().invalidDate();
    }

    var seconds = abs$1(this._milliseconds) / 1000;
    var days         = abs$1(this._days);
    var months       = abs$1(this._months);
    var minutes, hours, years;

    // 3600 seconds -> 60 minutes -> 1 hour
    minutes           = absFloor(seconds / 60);
    hours             = absFloor(minutes / 60);
    seconds %= 60;
    minutes %= 60;

    // 12 months -> 1 year
    years  = absFloor(months / 12);
    months %= 12;


    // inspired by https://github.com/dordille/moment-isoduration/blob/master/moment.isoduration.js
    var Y = years;
    var M = months;
    var D = days;
    var h = hours;
    var m = minutes;
    var s = seconds ? seconds.toFixed(3).replace(/\.?0+$/, '') : '';
    var total = this.asSeconds();

    if (!total) {
        // this is the same as C#'s (Noda) and python (isodate)...
        // but not other JS (goog.date)
        return 'P0D';
    }

    var totalSign = total < 0 ? '-' : '';
    var ymSign = sign(this._months) !== sign(total) ? '-' : '';
    var daysSign = sign(this._days) !== sign(total) ? '-' : '';
    var hmsSign = sign(this._milliseconds) !== sign(total) ? '-' : '';

    return totalSign + 'P' +
        (Y ? ymSign + Y + 'Y' : '') +
        (M ? ymSign + M + 'M' : '') +
        (D ? daysSign + D + 'D' : '') +
        ((h || m || s) ? 'T' : '') +
        (h ? hmsSign + h + 'H' : '') +
        (m ? hmsSign + m + 'M' : '') +
        (s ? hmsSign + s + 'S' : '');
}

var proto$2 = Duration.prototype;

proto$2.isValid        = isValid$1;
proto$2.abs            = abs;
proto$2.add            = add$1;
proto$2.subtract       = subtract$1;
proto$2.as             = as;
proto$2.asMilliseconds = asMilliseconds;
proto$2.asSeconds      = asSeconds;
proto$2.asMinutes      = asMinutes;
proto$2.asHours        = asHours;
proto$2.asDays         = asDays;
proto$2.asWeeks        = asWeeks;
proto$2.asMonths       = asMonths;
proto$2.asYears        = asYears;
proto$2.valueOf        = valueOf$1;
proto$2._bubble        = bubble;
proto$2.clone          = clone$1;
proto$2.get            = get$2;
proto$2.milliseconds   = milliseconds;
proto$2.seconds        = seconds;
proto$2.minutes        = minutes;
proto$2.hours          = hours;
proto$2.days           = days;
proto$2.weeks          = weeks;
proto$2.months         = months;
proto$2.years          = years;
proto$2.humanize       = humanize;
proto$2.toISOString    = toISOString$1;
proto$2.toString       = toISOString$1;
proto$2.toJSON         = toISOString$1;
proto$2.locale         = locale;
proto$2.localeData     = localeData;

// Deprecations
proto$2.toIsoString = deprecate('toIsoString() is deprecated. Please use toISOString() instead (notice the capitals)', toISOString$1);
proto$2.lang = lang;

// Side effect imports

// FORMATTING

addFormatToken('X', 0, 0, 'unix');
addFormatToken('x', 0, 0, 'valueOf');

// PARSING

addRegexToken('x', matchSigned);
addRegexToken('X', matchTimestamp);
addParseToken('X', function (input, array, config) {
    config._d = new Date(parseFloat(input, 10) * 1000);
});
addParseToken('x', function (input, array, config) {
    config._d = new Date(toInt(input));
});

// Side effect imports


hooks.version = '2.19.1';

setHookCallback(createLocal);

hooks.fn                    = proto;
hooks.min                   = min;
hooks.max                   = max;
hooks.now                   = now;
hooks.utc                   = createUTC;
hooks.unix                  = createUnix;
hooks.months                = listMonths;
hooks.isDate                = isDate;
hooks.locale                = getSetGlobalLocale;
hooks.invalid               = createInvalid;
hooks.duration              = createDuration;
hooks.isMoment              = isMoment;
hooks.weekdays              = listWeekdays;
hooks.parseZone             = createInZone;
hooks.localeData            = getLocale;
hooks.isDuration            = isDuration;
hooks.monthsShort           = listMonthsShort;
hooks.weekdaysMin           = listWeekdaysMin;
hooks.defineLocale          = defineLocale;
hooks.updateLocale          = updateLocale;
hooks.locales               = listLocales;
hooks.weekdaysShort         = listWeekdaysShort;
hooks.normalizeUnits        = normalizeUnits;
hooks.relativeTimeRounding  = getSetRelativeTimeRounding;
hooks.relativeTimeThreshold = getSetRelativeTimeThreshold;
hooks.calendarFormat        = getCalendarFormat;
hooks.prototype             = proto;

return hooks;

})));
    Array.prototype.filterAssoc = function(callback) {
        var a = this.slice();
        a.map(function(v, k, a) {
            if(!callback(v, k, a)) delete a[k];
        });
        return a;
    };
    

    jQuery(document).on('click', 'a.show_me_how', function() {
        jQuery('.yourMeals').css('display','block');
    });
    jQuery(document).on('click', 'button.close', function() {
        jQuery('.yourMeals').css('display','none');
    });
  

   // Popup Modal of sides

    jQuery(document).on('click', '.AllinonePopup #btn-side', function(e) {
    	e.preventDefault();
    	 var meal_id    =   jQuery(this).data('mealid');
          var choice_id    =   jQuery(this).data('choiceid');
    	 var side_title = jQuery(".sides_radio_buttons input:checked").val();
    	 var side_id    = jQuery(".sides_radio_buttons input:checked").next("input[name='side-id-choice']").val();
    	jQuery(".rcSides tr.iofSidesDetails").each(function(){
    		if (typeof side_id === "undefined") {}else{
    			if(jQuery.isNumeric(side_id)){
                    var myMealChoice = side_title + '<input type="hidden" class="_meal_side_'+choice_id+meal_id+'" data-sideId='+side_id+' data-sideName="'+side_title+'" name="_Side" value="'+side_title+'">';
	    			
	             	jQuery(this).find('td.side-title'+choice_id+meal_id).html(myMealChoice);
	         	} 
	         }
        });
	
    });

    jQuery(document).on('click', '.AllinonePopup #btn-vegetable', function(e) {
    	e.preventDefault();
    	 var meal_id    =   jQuery(this).data('mealid');
          var choice_id    =   jQuery(this).data('choiceid');
    	 var vegetable_title = jQuery(".vegetables_radio_buttons input:checked").val();
    	 var vegetable_id    = jQuery(".vegetables_radio_buttons input:checked").next("input[name='vegetable-id-choice']").val();
    	jQuery(".rcSides tr.iofSidesDetails").each(function(){
    		if (typeof vegetable_id === "undefined") {}else{
    			if(jQuery.isNumeric(vegetable_id)){
                    var myMealChoice = vegetable_title + '<input type="hidden" class="_meal_side_'+choice_id+meal_id+'" data-vegId='+vegetable_id+' data-vegName="'+vegetable_title+'"  name="_Vegetable" value="'+vegetable_title+'">';
		             jQuery(this).find('td.vegetable-title'+choice_id+meal_id).html(myMealChoice);
         		}
         	}
        });
	
    });

    jQuery(document).on('click', '.AllinonePopup #btn-salad', function(e) {
    	e.preventDefault();
    	 var meal_id    =   jQuery(this).data('mealid');
    	 var choice_id    =   jQuery(this).data('choiceid');
    	 var salad_title = jQuery(".salads_radio_buttons input:checked").val();
    	 var salad_id    = jQuery(".salads_radio_buttons input:checked").next("input[name='salad-id-choice']").val();

    	jQuery(".rcSides tr.iofSidesDetails").each(function(){
    		if (typeof salad_id === "undefined") {}else{
	    		if(jQuery.isNumeric(salad_id)){
                    var myMealChoice = salad_title + '<input type="hidden" class="_meal_side_'+choice_id+meal_id+'" data-saladId='+salad_id+' data-saladName="'+salad_title+'" name="_Salad" value="'+salad_title+'">';
		             jQuery(this).find('td.salad-title'+choice_id+meal_id).html(myMealChoice);
	         	}
	         }
        });
	
    });

    jQuery(document).on('click', '.AllinonePopup #btn-bread', function(e) {
    	e.preventDefault();
    	 var meal_id    =   jQuery(this).data('mealid');
          var choice_id    =   jQuery(this).data('choiceid');
    	 var bread_title = jQuery(".breads_radio_buttons_rc input:checked").val();
    	 var bread_id    = jQuery(".breads_radio_buttons_rc input:checked").next("input[name='bread-id-choice']").val();
    	jQuery(".rcSides tr.iofSidesDetails").each(function(){
    		if (typeof bread_id === "undefined") {}else{
    			if(jQuery.isNumeric(bread_id)){
                    var myMealChoice = dessert_title + '<input type="hidden" class="_meal_side_'+choice_id+meal_id+'" data-dessertId='+dessert_id+' data-dessertName="'+dessert_title+'"  name="_Dessert" value="'+dessert_title+'">';
	             	jQuery(this).find('td.bread-title'+choice_id+meal_id).html(myMealChoice);	
	    		}
    		}

        });
	
    });

    jQuery(document).on('click', '.AllinonePopup #btn-dessert', function(e) {
    	e.preventDefault();
    	 var meal_id    =   jQuery(this).data('mealid');
          var choice_id    =   jQuery(this).data('choiceid');
    	 var dessert_title = jQuery(".desserts_radio_buttons input:checked").val();
    	 var dessert_id    = jQuery(".desserts_radio_buttons input:checked").next("input[name='dessert-id-choice']").val();
    	jQuery(".rcSides tr.iofSidesDetails").each(function(){
    		if (typeof dessert_id === "undefined") {}else{
    			if(jQuery.isNumeric(dessert_id)){
	    			var myMealChoice = dessert_title + '<input type="hidden" class="_meal_side_'+choice_id+meal_id+'" name="_Dessert" value="'+dessert_title+'">';
	             	jQuery(this).find('td.dessert-title'+choice_id+meal_id).html(myMealChoice);
             	}
         	}
        });
	
    });
  

    jQuery(document).on('click', '.AllinonePopup .thumbnail', function() {
        if(! jQuery(this).hasClass('item-selected') ) {
            var old_selected = jQuery(this).closest(".modal-body").find(".item-selected");
            old_selected.find('label').html('');
            old_selected.find('input[type=radio]').attr('checked', false);
            old_selected.removeClass('item-selected');
            jQuery(this).addClass('item-selected');
            jQuery(this).find('input[type=radio]').attr('checked', true);
            jQuery(this).find('label').html('<i class="fa fa-check" style="left: -15px;position: absolute;top: 4px; color: #86BD3D;"></i>');
        }
    });

    // End JS
        
    jQuery('form#recipient_code_form').on('submit', function(e) {
        e.preventDefault();
        var recipient_code = jQuery(this).find('input#recipient_code').val();
        jQuery(this).find('p#recipient_message').slideUp();
        jQuery(this).find('button[type=submit]').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
        jQuery.post(
            ajax_object.ajax_url,
            {
                "action": "verify_recipient_code",
                "recipient_code": recipient_code
            }
        )
        .done(function(data) {
            display_recipient_message(data.status, false);
            jQuery('div#recipient_code_container').after(data.data);
        })
        .fail(function(data) {
            var response = data.responseText;
            response = jQuery.parseJSON(response);
            if(response) {
                display_recipient_message(response.error, true);
            } else {
                display_recipient_message('Unexpected error occurred!', true);
            }

        });
    });


    jQuery(document).on('click','button.addMyWalletBtn',function(){
  
        var recipient_code = jQuery('#recipient_code').val();
        jQuery.post(
            ajax_object.ajax_url,
            {
                "action": "add_to_rc_wallet",
                "recipient_code": recipient_code
            }
        ).done(function(data) {
            jQuery('div#recipient_code_container').after(data.data);
            setTimeout(function(){     jQuery('.myWalletMsg').fadeOut('slow');  }, 1500);
        }).fail(function(data) {

        });

    });

    jQuery(document).on('click','button#logingRegister',function(){
        var recipient_code = jQuery('#recipient_code').val();
        jQuery('#loginRegisterModalPopup .woocommerce-form-login__submit').before('<input type="hidden" id="pop_recipient_code" name="pop_recipient_code" value="'+recipient_code+'">');
        jQuery('#loginRegisterModalPopup .woocommerce-form-register__submit').before('<input type="hidden" id="pop_recipient_code" name="pop_recipient_code" value="'+recipient_code+'">');
    });


    jQuery('#myTabs a').click(function (e) {
        e.preventDefault();
        jQuery(this).tab('show');
    });

	body.on('click', '#RCTab li a', function(e) {
    	jQuery('div.devThum.item-selected').each(function(i, obj) {
    		jQuery(this).find('input[type=checkbox]').click();
            jQuery(this).find('input[type=number]').attr('disabled', false);
            jQuery(this).removeClass('item-selected');
		});
    	var choiceID = jQuery(this).attr('data-choiceid');
    	var num_delivery = jQuery('input[name=_num_delivery_' + choiceID + ']').val();
        var my_num_qty = jQuery('input[name=_num_qty_' + choiceID + ']').val(); 
        var myPendingDateDelivery = parseInt(num_delivery) - parseInt(my_num_qty);
        var myPendingDelivery = '('+( (myPendingDateDelivery != 0)?myPendingDateDelivery:'NaN' )+')';
        jQuery('span.totalOrderPending').html(myPendingDelivery);
	});

    jQuery(document).on('click', 'a.pick_btn_toggle', function(e) {
        e.preventDefault();
        var meal_id = jQuery(this).data('meal_id');
        var item_id = jQuery(this).data('item_id');

        switch_meal_selection_toggle(e, meal_id, item_id, false,0);
    });

    jQuery(document).on('click', 'input[type=checkbox]', function(e) {
        var meal_id = jQuery(this).data('meal_id');
        var item_id = jQuery(this).data('item_id');
   
        switch_meal_selection_toggle(e, meal_id, item_id, true,1);
    });

    var deliveries = {};
    var deliveries_count = 0;
    jQuery(document).on('click', 'button.add_meals_delivery', function() {
		
        var item_id = jQuery(this).data('item_id');
        var deliveries_limit = parseInt(jQuery('div.choice_container_' + item_id).find('input[name=_num_delivery_' + item_id + ']').val());
        var deliveries_qty = parseInt(jQuery('div.choice_container_' + item_id).find('input[name=_choice_qty_' + item_id + ']').val());
        var delivery_date = jQuery('div.choice_container_' + item_id).find('input.pick_delivery_date').val();
        deliveries_limit = deliveries_limit * deliveries_qty;

        var my_deliveries_qty =  jQuery('input[name=_num_qty_' + item_id + ']').val(); 
        if(delivery_date) {
           	if (deliveries_limit >= parseInt(get_current_choice_qty(item_id)) + parseInt(my_deliveries_qty) ) {
                var selected_meals = jQuery('div.choice_container_' + item_id).find('.item-selected');

                if (selected_meals.length) {

                    var pick_limit = parseInt(jQuery('input[name=_choice_qty_' + item_id + ']').val());
                    var num_delivery = jQuery('input[name=_num_delivery_' + item_id + ']').val();
                    var num_total_deleveries = jQuery('input[name=_num_total_deleveries' + item_id + ']').val();
                    var qty_sum = 0;
                    selected_meals.each(function () {
                        var qty = jQuery(this).find('input[name=qty]').val();
                        qty_sum = qty_sum + parseInt(qty);
                    });
                    var my_num_qty = jQuery('input[name=_num_qty_' + item_id + ']').val(); 
                    if(isNaN(qty_sum)){
		            	jQuery('div.choice_container_' + item_id ).each(function () {
			                qty_sum = jQuery(this).find('input[name=qty').val();
			            });
		            }
		            	
		            var totalQtyUser = parseInt(qty_sum) +  parseInt(my_num_qty);	
		            if (num_delivery >=  totalQtyUser) {
	                         // Adujstment for multiple qty order on same
	                       	jQuery('input[name=_num_qty_' + item_id + ']').val(parseInt(get_current_choice_qty(item_id)) + parseInt(my_deliveries_qty));
	                        var myPendingDateDelivery = parseInt( num_delivery) - jQuery('input[name=_num_qty_' + item_id + ']').val();
	                        var myPendingDelivery = '('+( (myPendingDateDelivery != 0)?myPendingDateDelivery:'0' )+')';
	                        var myPendingDeliveryTab = ( (myPendingDateDelivery != 0)?myPendingDateDelivery:'0' );
	                        var totalNumberOFDeliveries = jQuery('span.totalNumberOFDeliveries').html();
	                        var oldTabValue = jQuery('a.nav-link.active span.badge.badge-light').html();

	                        jQuery('span.totalOrderPending').html( myPendingDelivery);
	                        jQuery('a.nav-link.active span.badge.badge-light').html(myPendingDeliveryTab);
	                        if(myPendingDeliveryTab != '0'){
	                        	var myTabQty = oldTabValue - myPendingDeliveryTab;
	                        }else{
	                        	var myTabQty = oldTabValue;
	                        }
	                       	jQuery('span.totalNumberOFDeliveries').html( totalNumberOFDeliveries - myTabQty );

	                        selected_meals.each(function () {
	                            var sides = {};
	                            var id = jQuery(this).find('input[name=_meal_id]').val();
	                            if(id){
	                            	var qty = jQuery(this).find('input[name=qty]').val();
		                            var title = jQuery(this).find('input[name=meal_title]').val();
		                            jQuery(this).find('input._meal_side_'+item_id+id).each(function (id) {
		                                var name = jQuery(this).attr('name');
		                                var value = jQuery(this).attr('value');
		                                sides[name] = value;
		                            });
		                            sides.qty = parseInt(qty);
		                            sides.title = title;
		                            if (!deliveries[item_id]) {
		                                deliveries[item_id] = {};
		                            }
		                            if (!deliveries[item_id][delivery_date]) {
		                                deliveries[item_id][delivery_date] = {};
		                            }
		                            //Adjustment made to go around the bug of same item added on same date.
		                            if (!deliveries[item_id][delivery_date][id]) {
		                                deliveries_count = deliveries_count + sides.qty;
		                            }else{
		                                deliveries_count = deliveries_count + (parseInt(my_deliveries_qty) + parseInt(qty_sum));
		                            }
		                            deliveries[item_id][delivery_date][id] = sides;
	                            }
	                            
	                        });

	                        show_new_delivery(item_id, deliveries, qty_sum, parseInt(get_current_choice_qty(item_id)),'' );
	                        refresh_summary(deliveries,item_id);
	                         
	                        setTimeout(function() {
						       	jQuery('.chooseDelivery .chooseDeliveryLeft').removeClass('showDiv');
						       	jQuery('.chooseDelivery .chooseDeliveryLeft').addClass('hideDiv');
						    }, 50);
	                            
	                    } else {
	                    	if(num_delivery == my_num_qty){
	                    		alert('You have (NaN) deliveries for this item!');
	                    	}else{
	                    		alert('You have ' + num_delivery + ' deliveries for this item!');	
	                    	}
	                        //alert('Please pick ' + pick_limit + ' meal(s) for each delivery!');
	                    }
		                               
                } else {
                    alert('No meal has been picked for this delivery!');
                }
            } else {
                alert('You only have (' + deliveries_limit + ') deliveries for this item!');
                 setTimeout(function() {
						       	jQuery('.chooseDelivery .chooseDeliveryLeft').removeClass('showDiv');
						       	jQuery('.chooseDelivery .chooseDeliveryLeft').addClass('hideDiv');
						    }, 50);
            }
            //code for ArrowHighlits
            if(jQuery('input[name=_num_qty_' + item_id + ']').val() > 0){
                jQuery('button.review_complete_deliveries').addClass('iofArrowHighlight');
                jQuery([document.documentElement, document.body]).animate({
                    scrollTop: jQuery("#recipient_code_container").offset().top
                }, 2000);
            }
        } else {
            alert('No delivery date selected!');
        }
    });

    jQuery(document).on('click', 'a.delete_delivery', function(e) {
    	e.preventDefault();
    	if(confirm("Are you sure you want to delete this?")){
    		var date = jQuery(this).data('delivery_date');
	        var item_id = jQuery(this).data('item_id');
	        var myqty = jQuery(this).data('myqty');
	        var count_vav = Object.keys(deliveries[item_id][date]).length;
	        deliveries_count = deliveries_count - count_vav;

	        var delivery_boxs_arr = [];
	        var counter_arr = [];
        	jQuery('div.deliveries_details_' + item_id).find('.delivery_box').each(function () {
        		if(jQuery(this).find('a.delete_delivery').data('delivery_date') === date){
        			delivery_boxs_arr.push(jQuery(this).find('a.delete_delivery').data('myqty'));		
        		}
        		counter_arr.push(1);
            });
        	var myQtyFinal = '';
            if(counter_arr.length > 1){
            	if(counter_arr.length==2){
            		var myQtyFinal = parseInt(delivery_boxs_arr[0]) - 1;
            	}else if(counter_arr.length==3){
					var myQtyFinal = parseInt(delivery_boxs_arr[0]) - 2;
            	}else if(counter_arr.length==4){
					var myQtyFinal = parseInt(delivery_boxs_arr[0]) - 3;
            	}else if(counter_arr.length==5){
					var myQtyFinal = parseInt(delivery_boxs_arr[0]) - 4;
            	}
            }

            var resetQty = jQuery('input[name=_num_qty_' + item_id + ']').val();
            if(myQtyFinal == 0){
            	var resetFinal = parseInt(resetQty) - parseInt(delivery_boxs_arr[0]);
            }else{
            	var resetFinal = parseInt(resetQty) - parseInt(myQtyFinal);	
            }
	        
			jQuery('input[name=_num_qty_' + item_id + ']').val(resetFinal);
	        

	        var num_qty_item = jQuery('input[name=_num_qty_' + item_id + ']').val();
	        var num_delivery_item = jQuery('input[name=_num_delivery_' + item_id + ']').val();
	        var resetTabs = num_delivery_item - num_qty_item;

	        jQuery('span.totalOrderPending').html( '('+ resetTabs+')');

	        var oldTabValue = jQuery('a.nav-link.active span.badge.badge-light').html();
			jQuery('a.nav-link.active span.badge.badge-light').html( resetTabs);

			
			var spanArr = [];
			jQuery('#RCTab li a').find('span.badge').each(function () {
       			spanArr.push(jQuery(this).html());		
            });

            var allListOfTabs = 0;
			for (var i = 0; i < spanArr.length; i++) {
			    allListOfTabs += spanArr[i] << 0;
			}
			jQuery('span.totalNumberOFDeliveries').html(allListOfTabs);

            //code for ArrowHighlits
            if(deliveries_count == 0){
                jQuery('button.review_complete_deliveries').removeClass('iofArrowHighlight');
            }

	        delete deliveries[item_id][date];
	        show_new_delivery(item_id, deliveries,'','', resetFinal);
	        refresh_summary(deliveries,item_id);
	        return true;
	    }
	    else{
	        return false;
	    }
       
    });

    jQuery(document).on('click', 'input.qty', function() {
        jQuery("input[name='update_cart']").attr("disabled", false);
    });

    jQuery(document).on('click', 'button.review_complete_deliveries', function() {
         var num_qty =  parseInt( jQuery('input:hidden.num_qty').val() );
        var containers = jQuery('div.choice_container');
        var num_delivery =jQuery('.num_delivery').val();
        var limit = 0;
        var myQty = 0;
        containers.each(function() {
            var deliveries_limit = parseInt( jQuery(this).find('input:hidden.num_delivery').val() );
            var num_tot_qty =  parseInt(  jQuery(this).find('input:hidden.num_qty').val() );
            var deliveries_qty = parseInt( jQuery(this).find('input.num_qty').val() );
            limit = limit + ( deliveries_limit * deliveries_qty );
            myQty = myQty + num_tot_qty;
        });
   
        /*if(deliveries_count === limit) {*/
        if(myQty >= 1){
            jQuery('div.pick_your_meals_container').fadeToggle(1000);
            jQuery('div.review_confirm_container').fadeToggle(1000);
        } else {
        	if(limit == 0 && myQty == 0){
        		alert('You still have (' + ( num_delivery) + ') meal(s) to pick.');
        	}else{
        		alert('You still have (' + ( limit - myQty) + ') meal(s) to pick.');
        	}
            
        }
    });

    jQuery(document).on('click', 'button.back_to', function() {
        jQuery('div.pick_your_meals_container').fadeToggle(1000);
        jQuery('div.review_confirm_container').fadeToggle(1000);
    });

    jQuery(document).on('click', 'button.complete_order', function() {
        jQuery(this).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
        var recipient_code = jQuery('input[name=recipient_code]').val();
        var customer_note = jQuery('textarea[name=customer_note]').val();
		var lst_to = [];
	    $("input:hidden.num_qty").each(function() {
	        lst_to.push($(this).val());
	    });
	    var devidedByTabArr = lst_to.join();
	    var totNumQty_to = [];
	    $("input:hidden.num_tot_qty").each(function() {
	        totNumQty_to.push($(this).val());
	    });
	    var totalNumArr = totNumQty_to.join();
    
        jQuery.post(
            ajax_object.ajax_url,
            {
                "action": "complete_recipient_choice",
                "recipient_code": recipient_code,
                "myQtyArr":devidedByTabArr,
                "totalNumArr":totalNumArr,
                "recipient_choice": deliveries,
                "customer_note": customer_note
            }
        )
            .done(function(data) {
                jQuery('button.complete_order').html('Confirm!');
                var el = jQuery('div#recipient_code_container');
                var pick_your_meal_container = el.next();
                var back_to = jQuery('button.back_to');
                var complete_order = jQuery('button.complete_order');
                jQuery('textarea[name=customer_note]').attr('disabled', true);

                el.find('p#recipient_message').slideToggle();
                back_to.remove();
                complete_order.remove();
                pick_your_meal_container.remove();
                jQuery('span.thankyoumsg').css('display','block');
                
                if(data.shipping_method_id == 'flat_rate' || data.shipping_method_id == 'flat_rate'){
                    jQuery('div.getShippingDetailAfterOrder').after('<ul class="flatRateOrder full"><li><div class="flatRateBox"><p class="localPickTitle" style="background-color:#eef6e1">Delivery Details</p><p> Your order number is <strong>#'+data.orderid+'</strong></p><p>Your Meal will be delivered between the hours of 3 & 6 PM </p></div></li></ul>');    
                }
                if(data.shipping_method_id == 'local_pickup' || data.shipping_method_id == 'local_pickup'){
                    jQuery('div.getShippingDetailAfterOrder').after('<ul class="flatRateOrder full"><li><div class="flatRateBox"><p class="localPickTitle">Local Pickup Information</p><p class="localPickSubTitle">You Selected Local Pickup for your order. Please note the following pickup information</p><p> Your order number is <strong>#'+data.orderid+'</strong></p><p>Time Frame - <strong>1:00 PM to 6:00PM EST</strong></p><p>Location - <strong>'+data.location+'</strong></p></div></li></ul>'   );    
                }

                el.find('form#recipient_code_form').append('<button type="submit" class="btn btn-lg btn-success">Redeem!</button>');
                display_recipient_message(data.success, false);
            })
            .fail(function(data) {
                jQuery('div#recipient_code_container').find('p#recipient_message').slideToggle();
                jQuery('button.complete_order').html('Confirm!');
                var response = data.responseText;
                response = jQuery.parseJSON(response);
                if(response) {
                    display_recipient_message(response.error, true);
                } else {
                    display_recipient_message('Unexpected error occurred!', true);
                }
            });
    });

    function get_current_choice_qty(item_id) {
        var tmp_del = deliveries[item_id];
        var count = 0;

        /*jQuery.each(tmp_del, function(index, items) {
            jQuery.each(items, function(key, item) {
            	 count = count + item.qty;
			});
        });*/
        /*if(count == 0){*/
        	var qty_d = [];
        	jQuery('div.choice_container_' + item_id).find('.item-selected').each(function () {
        		if(jQuery(this).find('input[name=qty]').val()){
        			qty_d.push(jQuery(this).find('input[name=qty]').val());	
        		}
            });

            var totalQty = 0;
			for (var i = 0; i < qty_d.length; i++) {
			    totalQty += qty_d[i] << 0;
			}
            count = totalQty;
        /*}*/
       
        /*if(isNaN(count)){
        	count = 1;
        }*/
        
        return count;
    }

    
    function display_recipient_message(message, is_error) {
        var el = jQuery('form#recipient_code_form');
        if(is_error) {
            el.find('p#recipient_message')
                .find('small')
                .html(message)
                .removeClass('text-success')
                .addClass('text-danger');
            el.find('p#recipient_message').slideToggle();
            el.find('button[type=submit]').html('Redeem!');
        } else {
            el.find('p#recipient_message')
                .find('small')
                .html(message)
                .removeClass('text-danger')
                .addClass('text-success');
            el.find('p#recipient_message').slideToggle();
            el.find('button[type=submit]').html('Redeem!').remove();
        }
    }

    function switch_meal_selection_toggle(e, meal_id, item_id, is_checkbox,mycheck) {
        var pick_limit = jQuery('input[name=_choice_qty_' + item_id + ']').val();
        var num_delivery = jQuery('input[name=_num_delivery_' + item_id + ']').val();
        var num_total_deleveries = jQuery('input[name=_num_total_deleveries' + item_id + ']').val();

        var el = jQuery('div.meal_container_' + meal_id);
        var qty_sum = parseInt(el.find('input[name=qty]').val());
        

        if(qty_sum) {
      
 			jQuery('div.choice_container_' + item_id).find('.item-selected').each(function () {
                var qty = jQuery(this).find('input[name=qty]').val();
                qty_sum = qty_sum + parseInt(qty);
            });
            if(isNaN(qty_sum) || qty_sum == 'NaN'){
            	jQuery('div.choice_container_' + item_id).each(function () {
	                	qty_sum = jQuery(this).find('input[name=qty').val();
	            });
            }
            if (parseInt(num_total_deleveries) >=  parseInt(num_delivery) || el.hasClass('item-selected')) {
            	var checked = jQuery(".meal_details input[type=checkbox]:checked").length;
            	if(mycheck == 1){
            		if (checked > 0) {
		                highlight_meal_selection(el, meal_id, is_checkbox,checked,11);
		                return true;
		            } else {
		                highlight_meal_selection(el, meal_id, is_checkbox,0,11);
		                return false;
		            }
            	}else{
            		if (checked > 0) {
		                highlight_meal_selection(el, meal_id, is_checkbox,checked,22);
		                return true;
		            } else {
		                highlight_meal_selection(el, meal_id, is_checkbox,0,22);
		                return false;
		            }
            	}

            	
	            

               
            } else {
                e.preventDefault();
                alert('You can only pick ' + num_delivery + ' meal(s) per delivery!');
            }
        }
    }

    function show_new_delivery(item_id, deliveries,qty_sum, myQty,deleteVal) {
    	var my_num_qty = jQuery('input[name=_num_qty_' + item_id + ']').val();


        if(deliveries[item_id]) {
            var tmp_del = deliveries[item_id];

            var html = '';
            jQuery.each(tmp_del, function(index, value) {

            	if(myQty == '' || myQty == null){
    				FinalDeliveryBoxs = deleteVal;
    			}else{
    				var delivery_boxs = [];
		        	jQuery('div.deliveries_details_' + item_id).find('.delivery_box').each(function () {
		        		if(jQuery(this).find('a.delete_delivery').data('delivery_date') === index){
		        			delivery_boxs.push(jQuery(this).find('a.delete_delivery').data('myqty'));		
		        		}
		            });

		           	var FianlQty = 0;
					for (var i = 0; i < delivery_boxs.length; i++) {
					    FianlQty += delivery_boxs[i] << 0;
					}
					
		            if(parseInt(FianlQty)){
		            	var FinalDeliveryBoxs = parseInt(myQty) + parseInt(FianlQty);
		            }else{
		            	var FinalDeliveryBoxs = parseInt(myQty);
		            }
    			}



            	

            	var len = Object.keys(value).length;
             	html += '<div class="card delivery_box">' +
                    '  <div class="card-body">' +
                    '  <span class="delTitle"> Delivery Date: </span><span class="delDate"> <i>' + index + '</i></span><span class="delItems"> ' + len + ' items </span> ' + 
                    '  <span class="pull-right">' +
                    '<span class="delDelete"><a href="#" class="text-danger delete_delivery" data-myQty="'+FinalDeliveryBoxs+'" data-delivery_date="' + index + '" data-item_id="' + item_id + '"></a></span>' +
                    '</div>' +
                    '</div>';
            });
            jQuery('.deliveries_details_' + item_id).html(html);
            reset_item_selections(item_id);
        }
    }

     function reset_item_selections(item_id) {
        jQuery('div.choice_container_' + item_id).find('.item-selected').each(function() {
            jQuery(this).find('input[type=checkbox]').click();
            jQuery(this).find('input[type=number]').attr('disabled', false);
            jQuery(this).removeClass('item-selected');
        });
        /*jQuery('.chooseDelivery .chooseDeliveryLeft').removeClass('hideDiv');*/
        /*jQuery('.chooseDelivery .chooseDeliveryLeft').addClass('showDiv');*/

    }

    function highlight_meal_selection(el, meal_id, is_checkbox,checked,toggleCheck) {
        if(!is_checkbox) {
            var checkbox = jQuery('input[name=meal_' + meal_id + ']');
            checkbox.prop('checked', !checkbox.prop("checked"));
        }

        if(toggleCheck == 11){
        	 if(checked != 0){
	        	jQuery('.chooseDelivery .chooseDeliveryLeft').removeClass('hideDiv');
	            jQuery('.chooseDelivery .chooseDeliveryLeft').addClass('showDiv');
	        }else{
	        	jQuery('.chooseDelivery .chooseDeliveryLeft').removeClass('showDiv');
	            jQuery('.chooseDelivery .chooseDeliveryLeft').addClass('hideDiv');
	        }
        }else{

        	if(checked != 0){
        		jQuery('.chooseDelivery .chooseDeliveryLeft').removeClass('showDiv');
	            jQuery('.chooseDelivery .chooseDeliveryLeft').addClass('hideDiv');
	        	
	        }else{
	        	jQuery('.chooseDelivery .chooseDeliveryLeft').removeClass('hideDiv');
	            jQuery('.chooseDelivery .chooseDeliveryLeft').addClass('showDiv');
	        }

        }

        if (el.hasClass('item-selected')) {
            el.removeClass('item-selected');
            el.find('input[name=qty]').attr('disabled', false);
            jQuery('div.devThum').each(function(i, obj) {
                jQuery(this).find('input[type=checkbox]').attr('disabled',false);
                jQuery(this).find('input[type=number]').attr('disabled', false);
                jQuery(this).find('a.pick_btn_toggle').removeClass('disabled');
                jQuery('input.pick_delivery_date').val('');
                    
            });
        } else {
            el.addClass('item-selected');
            el.find('input[name=qty]').attr('disabled', true);
             jQuery('div.devThum').each(function(i, obj) {
                if(jQuery(this).hasClass('item-selected')){}else{
                    jQuery(this).find('input[type=checkbox]').attr('disabled',true);
                    jQuery(this).find('input[type=number]').attr('disabled', true);
                    jQuery(this).find('a.pick_btn_toggle').addClass('disabled');
                   jQuery('input.pick_delivery_date').val('');
                    
                }
            });
        }
    }

    function refresh_summary(deliveries,item_id) {
        var html = '<input type="hidden" value="'+item_id+'" class="my_item_id" value="myItemId" />';
        jQuery.each(deliveries, function(item, dates) {
        	html += '<div class="deliveryList">';
            jQuery.each(dates, function(date, items) {
            	html += '<div class="delivery_box rcDeliveryDateBox">';
                html += '<p> Delivery Date: <span>' + date + '</span></p>';
                jQuery.each(items, function(key, item) {
                	//alert(JSON.stringify(item));
                    var side_html = build_sides_summary(item);
                    html += '<h5>' + item.title + '</h5>' + side_html ;
                });
                html += '</div>';
            });
            html += '</div>';
        });

        jQuery('div.meals_summary').html(html);
    }

    function build_sides_summary(sides) {
        var side_html = '<ul>';
        if(sides._Side) {
            side_html += '<li><strong>Starches: </strong>' + sides._Side + '</li>';
        }
        if(sides._Vegetable) {
            side_html += '<li><strong>Vegetable: </strong>' + sides._Vegetable + '</li>';
        }
        if(sides._Salad) {
            side_html += '<li><strong>Salad: </strong>' + sides._Salad + '</li>';
        }
        if(sides._Bread) {
            side_html += '<li><strong>Bread: </strong>' + sides._Bread + '</li>';
        }
        if(sides._Dessert) {
            side_html += '<li><strong>Dessert: </strong>' + sides._Dessert + '</li>';
        }

         side_html += '</ul>';
        return side_html;
    }
});})( jQuery );