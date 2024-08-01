"use strict";(self.webpackChunklegalife=self.webpackChunklegalife||[]).push([[1954],{91954:(G,M,f)=>{f.d(M,{l:()=>C});var O=f(81490);class B{constructor(h){this.items=h,this.indexById={};for(let d=0;d<h.length;d++){const v=h[d].id;this.indexById[v]&&(0,O.c1)("two items have the same id",v),this.indexById[v]=d}}size(){return this.items.length}get(h){return this.items[h]}getIndex(h){return this.indexById[h]}getById(h){const d=this.indexById[h];return d===void 0?null:this.items[d]}asArray(){return this.items}containsId(h){return h in this.indexById}}var b=f(41231),y=f(17942),o=f(93320),w=f(31528);function C(j){if(!(j instanceof Array))throw new Error("Le questionnaire fourni n'est pas une liste YAML");const h=j,d=[];let v=null,P=[];const _={};function I(){const i={id:v.section,questions:new B(P),def:v};d.some(s=>s.id==i.id)&&(0,O.c1)("deux sections ont le m\xEAme intitul\xE9 : "+i.id),d.push(i),P=[]}return h.forEach(function(i){if(!i||typeof i!="object")throw new Error(`L'entr\xE9e ${i} n'est pas un object YAML`);if("section"in i)v&&I(),v=i;else if("data"in i){const s=i.property;if(!s)throw new Error(`"property manquante pour l'entr\xE9e data ${i}`);try{w.set(_,s,JSON.parse(i.data))}catch{if(typeof i.data=="string")w.set(_,s,i.data);else throw new Error("invalid json data for question "+JSON.stringify(i))}}else{if(!v)throw new Error("Le questionnaire ne commence pas par une section");const s=y.e.find(g=>g.labelProperty in i);let c=[];if(!s)c.push(`Type de question inconnu (valeurs valides ${JSON.stringify(y.e.map(g=>g.labelProperty))}`);else{s.defaultProperties&&Object.assign(i,s.defaultProperties());let g=[s.labelProperty];g=g.concat(s.requiredProperties||[]),s.readOnly||(g=g.concat(["property","demo"]));const L=["help","optional","default","readonly","hidden_in_qr","box_id","displays_in_box","autocomplete_off","default_phone_prefix"].concat(s.optionalProperties||[]),q=new b.I(g,L);c=c.concat(q.validate(i))}if(c.length)throw new Error(`${o.dump(i)}${c.join(`
`)}`);const N={id:s.readOnly?i[s.labelProperty]:i.property,property:i.property,demo:i.demo,default:i.default,optional:i.optional,readonly:i.readonly,type:s,def:i};P.push(N)}}),I(),{sections:new B(d),staticData:_}}},41231:(G,M,f)=>{f.d(M,{I:()=>O});class O{constructor(b,y){this.required=b,this.valid={},b.forEach(o=>this.valid[o]=!0),y.forEach(o=>this.valid[o]=!0)}validate(b){const y=[];this.required.forEach(function(o){o in b||y.push(`Propri\xE9t\xE9 manquante: "${o}"`)});for(const o in b)this.valid[o]||y.push(`Propri\xE9t\xE9 invalide: "${o}"`);return y}}},17942:(G,M,f)=>{f.d(M,{e:()=>s,u:()=>c});var O=f(41231),B=f(47084),b=f.n(B),y=f(82985),o=f.n(y),w=f(4300),C=f(63618),j=f(46373),h=f(63595),d=f(66649),v=f(63609),P=f(81490),_=(e,t,n)=>new Promise((r,a)=>{var l=m=>{try{u(n.next(m))}catch(x){a(x)}},p=m=>{try{u(n.throw(m))}catch(x){a(x)}},u=m=>m.done?r(m.value):Promise.resolve(m.value).then(l,p);u((n=n.apply(e,t)).next())});let I=1;function i(){return"question-"+I++}var s=[];function c(e){return e.replace(/[ \n]+/g," ")}let N;[{type:"text",extraClasses:"form-control"},{type:"date",htmlType:"text",extraClasses:"form-control datepicker-me",valueFromInput:e=>{const t=(0,d.NE)(e.val().toString(),"P");return(0,C.J)(t)?(0,j.WU)(t,"yyyy-MM-dd"):void 0},valueToText:e=>{if(!e)return"";const t=(0,h.D)(e);return(0,C.J)(t)?(0,d.FF)(t,"P"):""},extraInfo:{defaultProperties:()=>({demo:"2014-02-18"})}},{type:"number",extraClasses:"form-control",valueFromInput:e=>{const t=parseFloat(e.val().toString());return isNaN(t)?null:t},renderReadonly:e=>isNaN(e)?null:(0,w.dK)(e,3)},{type:"money",extraClasses:"form-control",valueFromInput:e=>{const t=parseFloat(e.val().toString());return isNaN(t)?null:t},renderReadonly:e=>isNaN(e)?null:(0,w.qk)(parseFloat(e))},{type:"tel",extraClasses:"form-control valid-tel",valueFromInput:e=>{const t=window["Iti-"+e[0].id];return t.isValidNumber()?t.getNumber():""},renderReadonly:e=>$("<a>",{href:"tel:"+e}).text(e),customizeInput:e=>_(void 0,null,function*(){var t;const n=document.getElementsByClassName("valid-tel")?document.getElementsByClassName("valid-tel")[0]:null;if(!n)return null;let r=n.getAttribute("data-default_phone_prefix");!r&&((t=document.getElementById("doc-data"))!=null&&t.textContent)&&(r=JSON.parse(document.getElementById("doc-data").textContent).default_phone_prefix);const a=r?yield(0,v.n6)(e[0],"NO_HIDDEN_ELEMENT",r):yield(0,v.n6)(e[0],"NO_HIDDEN_ELEMENT");return e.on("countrychange",function(){e.trigger("change")}),window["Iti-"+a.telInput.id]=a,a})},{type:"mailto",extraClasses:"form-control",renderReadonly:e=>$("<a>",{href:"mailto:"+e}).text(e)}].forEach(e=>{const t={labelProperty:e.type,getValue(n){let r=n.find("input").val();if(r&&(r=r.toString()),e.valueFromInput){const a=n.find("input");return e.valueFromInput(a)}return r},renderReadOnly(n,r){if(!r)return!1;let a;return e.renderReadonly?a=e.renderReadonly(r):e.valueToText?a=e.valueToText(r):a=r,n.append(" ").append(a||""),!0},render(n,r){const a=i(),l=e.valueToText?e.valueToText(r.def.demo):r.def.demo,p=e.valueToText?e.valueToText(r.value):r.value,u=c(`
			<label for="{{id}}">{{label}}{{ info.helpButton | safe }}{% if info.required %} (`+(0,d.fG)("generated.required1")+`) {% endif%}</label>
			<input id="{{id}}" name="{{info.def.property}}" class="{{extraClasses}}" data-default_phone_prefix="{{info.def.default_phone_prefix}}" {% if info.def.autocomplete_off %}autocomplete="disabled"{% endif %} {% if info.required %}required{% endif %} {%if info.def.readonly %}disabled{%endif%} type="{{type}}" placeholder="ex : {{demo}}" value="{{value}}"/>
			`),m=o().renderString(u,{id:a,info:r,value:p,demo:l,label:r.def[e.type],type:e.htmlType||e.type,extraClasses:e.extraClasses});n.append(m),e.customizeInput&&e.customizeInput(n.find("input"))},renderMaterial(n,r){if(r.def.hidden_in_qr)return;const a=i(),l=e.valueToText?e.valueToText(r.def.demo):r.def.demo,p=e.valueToText?e.valueToText(r.value):r.value,u=r.def[e.type]?'<label for="{{id}}">{{label}}{% if info.required %} ('+(0,d.fG)("generated.required1")+"){% endif %}</label>":"",m=c(`
			<div class="form-group">
			`+u+`
				<input id="{{id}}" name="{{info.def.property}}" class="{{extraClasses}}" {% if info.def.autocomplete_off %}autocomplete="disabled"{% endif %} {% if info.required %}required{% endif %} {%if info.def.readonly %}disabled{%endif%} type="{{type}}" placeholder="ex : {{demo}}" value="{{value}}" class="form-control" />
			</div>
			`),x=o().renderString(m,{id:a,info:r,value:p,demo:l,label:r.def[e.type],type:e.htmlType||e.type,extraClasses:e.extraClasses});n.append(x),e.customizeInput&&e.customizeInput(n.find("input"))},optionalProperties:["required"],previewDefaultValue:function(n){return n.required?"____":null}};Object.assign(t,e.extraInfo),s.push(t)}),s.push({labelProperty:"box",readOnly:!0,getValue(e){return null},renderReadOnly(e,t,n){return e.append($('<h4 class="qr-title">').text(n.box)),!0},render(e,t){},renderMaterial(e,t){if(t.def.hidden_in_qr)return;const n=i(),r=c(`
			<div class="card">
				<div class="card-header">
					<span class="mb-0">
						<button class="btn btn-link collapsed qr-panel unset-btn-border" type="button" style="padding-left:0;" data-toggle="collapse" data-target="#{{def.box_id}}_target">
							<h3 class="qr-title" style="color:#000;"><i class="fa"></i> {{def.box}}</h3>
						</button>
					</span>
				</div>
				<div id="{{def.box_id}}_target" class="collapse">
					<div id="{{def.box_id}}" class="card-body" data-type="box">
					</div>
    			</div>
  			</div>
		`),a=o().renderString(r,Object.assign({id:n},t));e.append(a)}}),s.push({labelProperty:"textarea",getValue(e){return e.find("textarea").val()},renderReadOnly(e,t){const n=t||"Non renseign\xE9";return e.append(" "+n),!0},render(e,t){const n=i(),r=c(`
		<label for="{{id}}">{{def.textarea}}{{ helpButton | safe }}</label>
		<textarea id="{{id}}" {% if required %}required{% endif %} {%if def.readonly %}disabled{%endif%} placeholder="ex : {{def.demo}}">{{value}}</textarea>
		`),a=o().renderString(r,Object.assign({id:n},t));e.append(a)},renderMaterial(e,t){if(t.def.hidden_in_qr)return;const n=i(),r=t.def.textarea?'<label for="{{id}}">{{def.textarea}}{% if required %} ('+(0,d.fG)("generated.required1")+"){% endif %}</label>":"",a=c(`
		<div class="form-group">
		`+r+`
			<textarea class="form-control" id="{{id}}" {% if required %}required{% endif %} {%if def.readonly %}disabled{%endif%} placeholder="ex : {{def.demo}}">{{value}}</textarea>
		</div>
		`),l=o().renderString(a,Object.assign({id:n},t));e.append(l)},optionalProperties:["required"],previewDefaultValue:function(e){return e.required?"____":null}}),s.push({labelProperty:"select",getValue(e){return e.find("select").val()},renderReadOnly(e,t,n){const r=n.choices;if(r){for(let a=0;a<r.length;a++)if(r[a].value==t)return e.append(" "+r[a].label),!0}return!1},render(e,t){const n=i(),r=c(`
		<label for="{{id}}">{{def.select}}{{ helpButton | safe }}</label>
		<select id="{{id}}" {% if required %}required{% endif %} {%if def.readonly %}disabled{%endif%} name="{{def.property}}" class="select-custom" placeholder="ex : {{def.demo}}">
		<option disabled value="" {% if not value %}selected{% endif %}>`+(0,d.fG)("generated.selectionnez_une_reponse")+`</option>
		{% for choice in def.choices %}
		<option value="{{choice.value}}" {% if value == choice.value %}selected{% endif %}>
		{{choice.label}}
		{% if choice.recommended %}
		(Le plus choisi)
		{% endif %}
		</option>
		{% endfor %}
		</select>
		`),a=o().renderString(r,Object.assign({id:n},t));e.append(a)},renderMaterial(e,t){if(t.def.hidden_in_qr)return;const n=i(),r=t.def.select?'<label for="{{id}}">{{def.select}}</label>':"",a=c(`
		<div class="form-group">
			<label for="{{id}}">{{def.select}}{% if required %} (`+(0,d.fG)("generated.required1")+`){% endif %}</label>
			<select title="`+(0,d.fG)("generated.selectionnez_une_reponse")+`" class="form-control selectpicker" data-style="btn btn-link" id="{{id}}" {% if required %}required{% endif %} {%if def.readonly %}disabled{%endif%} name="{{def.property}}" placeholder="ex : {{def.demo}}">
			{% for choice in def.choices %}
				<option value="{{choice.value}}" {% if value == choice.value %}selected{% endif %}>
					{{choice.label}}
				</option>
			{% endfor %}
			</select>
		</div>
		`),l=o().renderString(a,Object.assign({id:n},t));e.append(l)},requiredProperties:["choices"],validate(e){return q(e.choices)}}),s.push({labelProperty:"multi_select",getValue(e){return e.find(".multi-select").val()},renderReadOnly(e,t,n){if(t.length==0)return e.append((0,d.fG)("generated.none")),!0;const r=n.choices;if(!Array.isArray(t))return!1;const a=r.filter(l=>t.indexOf(l.value)>-1).map(l=>l.label);if(a.length==0)return!1;{const l=" "+a.join(", ");return e.append(l),!0}},render(e,t){const n=i(),r=t.def.choices,a=t.value||"";let l=`
		<label for="{{id}}">{{def.multi_select}}{{ helpButton | safe }}</label>
		<input onclick="toggleList();" id="{{id}}" type="text" class="multi-select" placeholder="`+(0,d.fG)("common.select_your_answers")+'" value="'+a+`" {% if required %}required{% endif %} readonly />
		<ul class="multi-choices hidden">
		`;r.forEach(function(u){a.includes(u.value)?l+='<li onclick="checkInput(this);" class="active"><input type="checkbox" value="'+u.value+'" checked /><span>'+u.label+"</span></li>":l+='<li onclick="checkInput(this);"><input type="checkbox" value="'+u.value+'" /><span>'+u.label+"</span></li>"}),l+=`
		</ul>
		`,l=c(l);const p=o().renderString(l,Object.assign({id:n},t));e.append(p)},renderMaterial(e,t){if(t.def.hidden_in_qr)return;const n=i(),r=t.def.choices,a=t.value||"";let l=`
		<label for="{{id}}">{{def.multi_select}}{{ helpButton | safe }}</label>
		<input onclick="toggleList();" id="{{id}}" type="text" class="multi-select" placeholder="`+(0,d.fG)("common.select_your_answers")+'" value="'+a+`" {% if required %}required{% endif %} readonly />
		<ul class="multi-choices hidden">
		`;r.forEach(function(u){a.includes(u.value)?l+='<li onclick="checkInput(this);" class="active"><input type="checkbox" value="'+u.value+'" checked /><span>'+u.label+"</span></li>":l+='<li onclick="checkInput(this);"><input type="checkbox" value="'+u.value+'" /><span>'+u.label+"</span></li>"}),l+=`
		</ul>
		`,l=c(l);const p=o().renderString(l,Object.assign({id:n},t));e.append(p)},requiredProperties:["choices"],validate(e){return q(e.choices)}}),s.push({labelProperty:"osm_select",getValue(e){const t=[];return e.find(":selected").each(function(){t.push(parseInt($(this).val()))}),t},renderReadOnly(e,t,n){let r=[];return $.ajax({type:"GET",url:"/admin/osm-areas/?idoa="+t,async:!1,success:a=>{r=a}}),e.append(r.join(", ")),!0},render(e,t){const n=i();if(t.value){var r;$.ajax({type:"GET",url:"/admin/osm-areas/?idoa="+t.value,async:!1,success:function(p){r=p}})}var a=`
			<label for="{{id}}">{{def.osm_select}}{{ helpButton | safe }}</label>
			<select id="{{id}}" multiple {% if required %}required{% endif %} {%if def.readonly %}disabled{%endif%} name="{{def.property}}[]" class="select-custom" placeholder="ex : {{def.demo}}">
		`;a+='<option disabled value="" {% if not value %}selected{% endif %}>'+(0,d.fG)("generated.selectionnez_une_reponse"),t.value&&(a+='<option value="'+t.value+'" selected>'+r+"</option></select>"),a+="</select>";var a=c(a);const l=o().renderString(a,Object.assign({id:n},t));e.append(l)},renderMaterial(e,t){if(t.def.hidden_in_qr)return;const n=i();let r=[];t.value&&$.ajax({type:"GET",url:"/admin/osm-areas/?idoa="+t.value,async:!1,success:function(p){r=p}});var a=t.def.osm_select?'<label for="{{id}}">{{def.osm_select}}</label>':"";a+=`
			<div class="form-group">
				<label for="{{id}}">{{def.select}}{% if required %} (`+(0,d.fG)("generated.required1")+`){% endif %}</label>
				<select multiple title="`+(0,d.fG)("generated.selectionnez_une_reponse")+`" class="form-control selectpicker unset-btn-border" data-style="btn btn-link" id="{{id}}" {% if required %}required{% endif %} {%if def.readonly %}disabled{%endif%} name="{{def.property}}[]" placeholder="ex : {{def.demo}}">
		`,$.each(t.value,function(p,u){a+=$("<option>").text(r[p]).attr("value",u).attr("selected",!0)[0].outerHTML}),a+="</select></div>";var a=c(a);const l=o().renderString(a,Object.assign({id:n},t));e.append(l)}});const L=new O.I(["label","value"],["help"]);function q(e){if(!(e instanceof Array))return['"choices" doit \xEAtre une liste YAML'];let t=[];return e.forEach(n=>t=t.concat(L.validate(n))),t}s.push({labelProperty:"yes_no",getValue(e){return e.find("input").prop("checked")},renderReadOnly(e,t){let n;return t===!0?n=" "+(0,d.fG)("generated.yes"):t===!1?n=" "+(0,d.fG)("generated.no"):((0,P.c1)("invalid boolean value : "+t),n=t),e.append(n),!0},render(e,t){const n="yes-no-"+I++,r=c(`
		<div class="table">
		<div class="table-row inputbox-wrapper">
		<div class="table-cell">
		<input id="{{id}}" {% if required %}required{% endif %} {%if def.readonly %}disabled{%endif%} class="fakeinputbox-me" type="checkbox" name="{{def.property}}" {% if value %}checked{% endif %}/>
		</div>
		<div class="table-cell right">
		<label for="{{id}}">{{def.yes_no}}{{ helpButton| safe }}</label>
		</div>
		</div>
		</div>
		`),a=o().renderString(r,Object.assign({id:n},t));e.append(a)},renderMaterial(e,t){if(t.def.hidden_in_qr)return;const n="yes-no-"+I++,r=c(`
		<div class="checkbox-radios">
			<div class="form-check">
				<label class="form-check-label">
					<input class="form-check-input" id="{{id}}" {% if required %}required{% endif %} {%if def.readonly %}disabled{%endif%} type="checkbox" name="{{def.property}}" {% if value %}checked{% endif %} /> {{def.yes_no}}{% if required %} (`+(0,d.fG)("generated.required1")+`){% endif %}
					<span class="form-check-sign">
						<span class="check"></span>
					</span>
				</label>
			</div>
		</div>
		`),a=o().renderString(r,Object.assign({id:n},t));e.append(a)}});const D={labelProperty:"radio",getValue(e){return e.find(":checked").val()},renderReadOnly(e,t,n){const r=n.choices;for(let a=0;a<r.length;a++)if(r[a].value==t)return e.append(" "+r[a].label),!0;return!1},render(e,t){const n=i(),r=c(`
		<label>{{def.radio}}{{ helpButton| safe }}</label>
		<div class="radiobox">
		{% for choice in def.choices %}
		{% set choiceid = id + loop.index0 %}
		<div class="table">
		<div class="table-row inputbox-wrapper">
		<div class="table-cell">
		<input id="{{ choiceid }}" {%if def.readonly %}disabled{%endif%} class="fakeinputbox-me" type="radio" name="{{def.property}}" value="{{choice.value}}" {% if value == choice.value %} checked{% endif %} {% if required %}required{% endif %}/>
		</div>
		<div class="table-cell right">
		<label for="{{choiceid}}">
		{{choice.label}}
		{% if choice.recommended %}
		<span class="qr-recommended">Le plus choisi</span>
		{% endif %}
		</label>
		</div>
		</div>
		</div>
		{% endfor %}
		</div>
		`),a=o().renderString(r,Object.assign({id:n},t));e.append(a)},renderMaterial(e,t){if(t.def.hidden_in_qr)return;const n=i(),r=t.def.radio?"<label>{{def.radio}}{% if required %} ("+(0,d.fG)("generated.required1")+"){% endif %}{{ helpButton| safe }}</label>":"",a=c(r+`
		<div class="radiobox">
		{% for choice in def.choices %}
		{% set choiceid = id + loop.index0 %}
		<div class="checkbox-radios">
			<div class="form-check">
				<label class="form-check-label">
					<input id="{{ choiceid }}" type="radio" class="form-check-input" name="{{def.property}}" value="{{choice.value}}" {% if required %}required{% endif %} {% if value == choice.value %} checked{% endif %} /> {{choice.label}}
					<span class="circle">
						<span class="check"></span>
					</span>
				</label>
			</div>
		</div>
		{% endfor %}
		</div>
		`),l=o().renderString(a,Object.assign({id:n},t));e.append(l)},requiredProperties:["choices"],validate(e){return q(e.choices)}};s.push(D),s.push({labelProperty:"yes_no_radio",getValue(e){if(!D.getValue)throw new Error("getValue cannot be undefined");return D.getValue(e)==="yes"},renderReadOnly(e,t){let n;return t===!0?n=" "+(0,d.fG)("generated.yes"):t===!1?n=" "+(0,d.fG)("generated.no"):((0,P.c1)("invalid boolean value : "+t),n=t),e.append(n),!0},render(e,t){const n={radio:t.def.yes_no_radio,choices:[{value:"yes",label:(0,d.fG)("generated.yes"),recommended:t.def.recommended===!0},{value:"no",label:(0,d.fG)("generated.no"),recommended:t.def.recommended===!1}],property:t.def.property};let r="";t.value===!0&&(r="yes"),t.value===!1&&(r="no"),D.render(e,{def:n,value:r,helpButton:t.helpButton,required:t.required})},renderMaterial(e,t){if(t.def.hidden_in_qr)return;const n={radio:t.def.yes_no_radio,choices:[{value:"yes",label:(0,d.fG)("generated.yes"),recommended:t.def.recommended===!0},{value:"no",label:(0,d.fG)("generated.no"),recommended:t.def.recommended===!1}],property:t.def.property};let r="";t.value===!0&&(r="yes"),t.value===!1&&(r="no"),D.renderMaterial(e,{def:n,value:r,helpButton:t.helpButton,required:t.required})},optionalProperties:["recommended"]}),s.push({labelProperty:"checkboxes",getValue(e){const t={},n=e.find(":checked").each(function(){t[$(this).val().toString()]=!0});return t},renderReadOnly(e,t,n){if(t.length==0)return e.append((0,d.fG)("generated.none")),!0;const r=n.choices,a=[];if(typeof t!="object")return!1;for(let l=0;l<r.length;l++)r[l].value in t&&a.push(r[l].label);if(a.length==0)return!1;{const l=" "+a.join(", ");return e.append(l),!0}},render(e,t){const n=i(),r=c(`
		<label>{{def.checkboxes}}{{ helpButton| safe }}</label>
		<div class="radiobox">
		{% for choice in def.choices %}
		{% set choiceid = id + loop.index0 %}
		<div class="table">
		<div class="table-row inputbox-wrapper">
		<div class="table-cell">
		<input id="{{choiceid}}" {%if def.readonly %}disabled{%endif%} class="fakeinputbox-me" type="checkbox" value="{{choice.value}}" {% if value[choice.value] %}checked{% endif %}/>
		</div>
		<div class="table-cell right">
		<label for="{{choiceid}}">
		{{choice.label}}
		{% if choice.recommended %}
		<span class="qr-recommended">Souvent choisi</span>
		{% endif %}
		</label>
		</div>
		</div>
		</div>
		{% endfor %}
		</div>
		`),a=o().renderString(r,Object.assign({id:n},t));e.append(a)},renderMaterial(e,t){if(t.def.hidden_in_qr)return;const n=i(),r=t.def.checkboxes?"<label>{{def.checkboxes}}{{ helpButton| safe }}</label>":"",a=c(r+`
		<div class="radiobox">
		{% for choice in def.choices %}
		{% set choiceid = id + loop.index0 %}
		<div class="checkbox-radios">
			<div class="form-check">
				<label class="form-check-label" style="margin-bottom:5px">
					<input class="form-check-input" id="{{choiceid}}" value="{{choice.value}}" {% if required %}required{% endif %} {%if def.readonly %}disabled{%endif%} type="checkbox" name="{{def.property}}" {% if value[choice.value] %}checked{% endif %} /> {{choice.label}}{% if required %} (`+(0,d.fG)("generated.required1")+`){% endif %}
					<span class="form-check-sign">
						<span class="check"></span>
					</span>
				</label>
			</div>
		</div>
		{% endfor %}
		</div>
		`),l=o().renderString(a,Object.assign({id:n},t));e.append(l)},requiredProperties:["choices"],validate(e){return q(e.choices)}}),s.push({labelProperty:"subheader",readOnly:!0,renderReadOnly(e,t,n){return e.append($('<h4 class="qr-title">').text(n.subheader)),!0},render(e,t){e.append($('<h2 class="qr-title">').text(t.def.subheader))},renderMaterial(e,t){t.def.hidden_in_qr||e.append($('<h3 class="qr-title">').text(t.def.subheader))}}),s.push({labelProperty:"markdown",readOnly:!0,renderReadOnly(e,t,n){return e.append(b()(n.markdown)),!0},render(e,t){e.append(b()(t.def.markdown))},renderMaterial(e,t){t.def.hidden_in_qr||e.append(b()(t.def.markdown))}}),s.push({labelProperty:"file",getValue(e){return _(this,null,function*(){function t(u){return _(this,null,function*(){return new Promise(function(m,x){const k=new FileReader;k.readAsDataURL(u),k.onload=function(){m(k.result)},k.onerror=function(T){x("Error: "+T)}})})}function n(u,m){return _(this,null,function*(){return new Promise(function(x,k){try{const T=new Image;T.src=u,T.onload=function(A){try{let E=A.target.width,R=A.target.height;if(E>1080){const U=E/R;E=1080,R=E/U}const S=document.createElement("canvas");S.width=E,S.height=R,S.getContext("2d").drawImage(A.target,0,0,E,R);const V=S.toDataURL("image/jpeg",m);x(V)}catch(E){k("Fail"+E)}}}catch(T){k("Fail"+T)}})})}const r=e.find("input").get(0).files;if(!r||!r[0])return e.find(".btn-add").text("Ajouter"),e.find(".btn-delete").hide(),null;const a=new Number(e.find("input").attr("data-quality")).valueOf(),l=yield t(r[0]),p=yield n(l,a);return e.find(".btn-add").text("Modifier"),e.find(".btn-delete").show(),p})},renderReadOnly(e,t,n){throw new Error("not implemented")},render(e,t){const n=i(),r=c(`
			<label>{{def.file}}{{ helpButton| safe }}</label>
			<button type="button" onclick="getElementById('{{def.property}}').click()" class="btn btn--alt btn-add">Ajouter</button>
			<button type="button" onclick="getElementById('{{def.property}}').value = null;
			var evt = document.createEvent('HTMLEvents');
			evt.initEvent('change', true, true);
			getElementById('{{def.property}}').dispatchEvent(evt);" class="btn btn--alt btn-delete" id="{{def.property}}delete" style="border-color: #ccc #ccc #999;color: #888;display:none">Supprimer</button>
			<input type="file" id="{{def.property}}" data-quality="{{def.quality}}" name="{{def.property}}" accept="image/png, image/jpeg">
			`),a=o().renderString(r,Object.assign({id:n},t));e.append(a)},renderMaterial(e,t){throw new Error("not implemented")},requiredProperties:["quality"],validate(e){return q(e.quality)}})}}]);
