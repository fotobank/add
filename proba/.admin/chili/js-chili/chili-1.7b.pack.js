/*
===============================================================================
Chili is a code highlighter based on jQuery
...............................................................................
                                               Copyright 2007 / Andrea Ercolino
-------------------------------------------------------------------------------
LICENSE: http://www.opensource.org/licenses/mit-license.php
MANUAL:  http://www.mondotondo.com/aercolino/noteslog/?page_id=79
UPDATES: http://www.mondotondo.com/aercolino/noteslog/?cat=8
===============================================================================
*/

eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)d[e(c)]=k[c]||e(c);k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('6={2L:"1.2K",1w:"2J",1y:"",1t:N,P:"",1s:N,O:"",1X:\'<1Y 1v="$0">$$</1Y>\',H:"&#A;",1a:"&#A;&#A;&#A;&#A;",19:"&#A;<1o/>",12:{},G:{}};(4($){$(4(){4 1F(h,7){4 1M(v,f){3 e=(1D f.e=="2I")?f.e:f.e.1d;q.16({v:v,e:"("+e+")",p:1+(e.9(/\\\\./g,"%").9(/\\[.*?\\]/g,"%").2H(/\\((?!\\?)/g)||[]).p,w:(f.w)?f.w:6.1X})}4 1L(){3 1f=0;3 1e=y 1N;13(3 i=0;i<q.p;i++){3 e=q[i].e;e=e.9(/\\\\\\\\|\\\\(\\d+)/g,4(m,1g){8!1g?m:"\\\\"+(1f+1+1R(1g))});1e.16(e);1f+=q[i].p}3 1d=1e.2G("|");8 y Z(1d,(7.2F)?"1x":"g")}4 1V(k){8 k.9(/&/g,"&2E;").9(/</g,"&2D;")}4 1U(k){8 k.9(/ +/g,4(1W){8 1W.9(/ /g,H)})}4 x(k){k=1V(k);5(H){k=1U(k)}8 k}4 1K(1P){3 i=0;3 j=1;3 f;1p(f=q[i++]){3 W=I;5(W[j]){3 1T=/(\\\\\\$)|(?:\\$\\$)|(?:\\$(\\d+))/g;3 w=f.w.9(1T,4(m,1S,K){3 2C=\'\';5(1S){8"$"}s 5(!K){8 x(W[j])}s 5(K=="0"){8 f.v}s{8 x(W[j+1R(K,10)])}});3 1c=I[I.p-2];3 1Q=I[I.p-1];3 1O=1Q.1J(V,1c);V=1c+1P.p;U+=x(1O)+w;8 w}s{j+=f.p}}}3 H=6.H;3 q=y 1N;13(3 v 2B 7.q){1M(v,7.q[v])}3 U="";3 V=0;h.9(1L(),1K);3 1I=h.1J(V,h.p);U+=x(1I);8 U}4 1r(T){5(!6.G[T]){3 R=\'<R 2A="15" 2z="l/1E"\'+\' 2y="\'+T+\'">\';6.G[T]=N;5($.2x.2w){3 S=D.1n(R);3 $S=$(S);$("1H").1G($S)}s{$("1H").1G(R)}}}4 11(a,7){3 h=a&&a.1b&&a.1b[0]&&a.1b[0].2v;5(!h)h="";h=h.9(/\\r\\n?/g,"\\n");3 z=1F(h,7);5(6.1a){z=z.9(/\\t/g,6.1a)}5(6.19){z=z.9(/\\n/g,6.19)}$(a).2u(z)}4 14(o,Q){3 18={P:6.P,1C:o+".2t",O:6.O,1B:o+".1E"};3 u;5(Q&&1D Q=="1z")u=$.2s(18,Q);s u=18;8{7:u.P+u.1C,15:u.O+u.1B}}5($.1A)$.1A({2r:"1z.M"});3 1u=y Z("\\\\b"+6.1y+"\\\\b","1x");3 Y=[];$(6.1w).1q(4(){3 a=E;3 17=$(a).2q("1v");5(!17){8}3 o=$.2p(17.9(1u,""));5(\'\'!=o){Y.16(a);3 c=14(o,a.M);5(6.1t||a.M){5(!6.G[c.7]){2o{6.G[c.7]=N;$.2n(c.7,4(F){F.c=c.7;6.12[c.7]=F;5(6.1s){1r(c.15)}$("."+o).1q(4(){3 c=14(o,E.M);5(F.c==c.7){11(E,F)}})})}2m(2l){2k("7 2j 13: "+o+\'@\'+2i)}}}s{3 7=6.12[c.7];5(7){11(a,7)}}}});5(D.X&&D.X.1l){4 1k(l){5(\'\'==l){8""}2h{3 L=(y 2g()).2f()}1p(l.2e(L)>-1);l=l.9(/\\<1o[^>]*?\\>/2d,L);3 a=D.1n(\'<1m>\');a.2c=l;l=a.2b.9(y Z(L,"g"),\'\\r\\n\');8 l}3 C="";3 J=1h;$(Y).2a().x("1m").B("1j",4(){J=E}).B("1i",4(){5(J==E)C=D.X.1l().29});$("28").B("27",4(){5(\'\'!=C){26.25.24(\'23\',1k(C));22.21=20}}).B("1j",4(){C=""}).B("1i",4(){J=1h})}})})(1Z);',62,172,'|||var|function|if|ChiliBook|recipe|return|replace|el||path||exp|step||ingredients|||str|text|||recipeName|length|steps||else||settings|stepName|replacement|filter|new|dish|160|bind|insidePRE|document|this|recipeLoaded|required|replaceSpace|arguments|downPRE||newline|chili|true|stylesheetFolder|recipeFolder|options|link|domLink|stylesheetPath|perfect|lastIndex|aux|selection|codes|RegExp||makeDish|recipes|for|getPath|stylesheet|push|elClass|settingsDef|replaceNewLine|replaceTab|childNodes|offset|source|exps|prevLength|aNum|null|mouseup|mousedown|preformatted|createRange|pre|createElement|br|while|each|checkCSS|stylesheetLoading|recipeLoading|selectClass|class|elementPath|gi|elementClass|object|metaobjects|stylesheetFile|recipeFile|typeof|css|cook|append|head|lastUnmatched|substring|chef|knowHow|prepareStep|Array|unmatched|matched|input|parseInt|escaped|pattern|replaceSpaces|escapeHTML|spaces|defaultReplacement|span|jQuery|false|returnValue|event|Text|setData|clipboardData|window|copy|body|htmlText|parents|innerText|innerHTML|ig|indexOf|valueOf|Date|do|recipePath|unavailable|alert|recipeNotAvailable|catch|getJSON|try|trim|attr|selector|extend|js|html|data|msie|browser|href|type|rel|in|bit|lt|amp|ignoreCase|join|match|string|code|7b|version'.split('|'),0,{}))