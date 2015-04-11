/* =============================================================
 * filemanager.js v0.2.1 - 5/10/2014
 * ============================================================ */
(function($){
	$.tree={
		datastores:{},
		defaults:{
			data:{
				opts:{url:false}
			},
			selected:'top',
			opened:['top'],
			callback:{
				beforedata:function(a,b){ 
					if(a==false){
						b.settings.data.opts.static=[{
							data:'image',
							attributes:{ 
								'id':'top',
								'directory':''
							},
							state:'closed'
						}];
						return{'directory':''}
					}else{
						b.settings.data.opts.static=false;
						return{'directory':$(a).attr('directory')}
					}
				},	
				onselect:function(a,b){},
				error:function(TEXT,b){},
				oninit:function(b){}
			}
		},
		focused:function(){
			return tree_component.inst[tree_component.focused]
		}
	};
	$.fn.tree=function(opts){
		return this.each(function(){
			var conf=$.extend({},opts);
			if(tree_component.inst&&tree_component.inst[$(this).attr('id')]) tree_component.inst[$(this).attr('id')].destroy();
			if(conf!==false) new tree_component().init(this,conf)
		})
	};
	function tree_component(){
		return{
			cntr:++tree_component.cntr,
			settings:$.extend({},$.tree.defaults),
			init:function(elem,conf){
				var _this=this;
				this.container=$(elem);
				if(this.container.size==0) return false;
				tree_component.inst[this.cntr]=this;
				if(!this.container.attr("id"))this.container.attr("id","jstree_"+this.cntr);
				tree_component.inst[this.container.attr("id")]=tree_component.inst[this.cntr];
				tree_component.focused=this.cntr;
				this.settings=$.extend(true,{},this.settings,conf);
				this.container.addClass("tree");
				this.offset=false;
				this.callback("oninit",[this]);
				this.refresh();
				this.attach_events();
				this.focus()
			},
			refresh:function(obj){
				var _this=this;
				this.is_partial_refresh=obj?true:false;
				this.opened=Array();
				if(this.settings.opened!=false){
					$.each(this.settings.opened,function(i,item){
						if(this.replace(/^#/,"").length>0){
							_this.opened.push("#"+this.replace(/^#/,""))
						}
					});
					this.settings.opened=false
				} else{
					this.container.find("li.open").each(function(i){
						if(this.id){
							_this.opened.push("#"+this.id)
						}
					})
				}
				if(this.selected){
					this.settings.selected=Array();
					if(obj){
						$(obj).find("li:has(a.clicked)").each(function(){
							if(this.id)_this.settings.selected.push("#"+this.id)
						})
					} else{
						if(this.selected_arr){
							$.each(this.selected_arr,function(){
								if(this.attr("id"))_this.settings.selected.push("#"+this.attr("id"))
							})
						} else{
							if(this.selected.attr("id"))this.settings.selected.push("#"+this.selected.attr("id"))
						}
					}
				} else if(this.settings.selected!==false){
					var tmp=Array();
					if((typeof this.settings.selected).toLowerCase()=="object"){
						$.each(this.settings.selected,function(){
							if(this.replace(/^#/,"").length>0) tmp.push("#"+this.replace(/^#/,""))
						})
					} else{
						if(this.settings.selected.replace(/^#/,"").length>0) tmp.push("#"+this.settings.selected.replace(/^#/,""))
					}
					this.settings.selected=tmp
				}
				if(obj){
					this.opened=Array();
					obj=this.get_node(obj);
					obj.find("li.open").each(function(i){
						_this.opened.push("#"+this.id)
					});
					if(obj.hasClass("open"))obj.removeClass("open").addClass("closed");
					if(obj.hasClass("leaf"))obj.removeClass("leaf");
					obj.children("ul:eq(0)").html("");
					return this.open_branch(obj,true,function(){
						_this.reselect.apply(_this)
					})
				}
				var _this=this;
				var _datastore=new $.tree.datastores['json']();
				if(this.container.children("ul").size()==0){
					this.container.html('<ul class="nav"><li><i class="icon-load"></i> loading...</li></ul>')
				}
				_datastore.load(this.callback("beforedata",[false,this]),this,this.settings.data.opts,function(data){
					_datastore.parse(data,_this,_this.settings.data.opts,function(str){
						_this.container.empty().append($("<ul class='nav'>").html(str));
						_this.container.find("li:last-child").end().find("li:has(ul)").not(".open").addClass("closed");
						_this.container.find("li").not(".open").not(".closed").addClass("leaf");
						_this.reselect()
					})
				})
			},
			reselect:function(is_callback){
				var _this=this;
				if(!is_callback) this.cl_count=0;
				else this.cl_count--;
				if(this.opened&&this.opened.length){
					var opn=false;
					for(var j=0;this.opened&&j<this.opened.length;j++){
						var tmp=this.get_node(this.opened[j]);
						if(tmp.size()&&tmp.hasClass("closed")>0){
							opn=true;
							var tmp=this.opened[j].toString().replace('/','\\/');
							delete this.opened[j];
							this.open_branch(tmp,true,function(){
								_this.reselect.apply(_this,[true])
							});
							this.cl_count++
						}
					}
					if(opn) return;
					if(this.cl_count>0) return;
					delete this.opened
				}
				if(this.cl_count>0) return;
				if(this.scrtop){
					this.container.scrollTop(_this.scrtop);
					delete this.scrtop
				}
				if(this.settings.selected!==false){
					$.each(this.settings.selected,function(i){
						if(_this.is_partial_refresh)
							_this.select_branch($(_this.settings.selected[i].toString().replace('/','\\/'),_this.container));
						else
							_this.select_branch($(_this.settings.selected[i].toString().replace('/','\\/'),_this.container))
					});
					this.settings.selected=false
				}
			},
			get:function(obj,format,opts){
				if(!format) format='json';
				if(!opts) opts=this.settings.data.opts;
				return new $.tree.datastores[format]().get(obj,this,opts)
			},
			attach_events:function(){
				var _this=this;
				this.container.bind("mousedown.jstree",function(event){
				}).bind("mouseup.jstree",function(event){
					setTimeout(function(){
						_this.focus.apply(_this)
					},5)
				}).bind("click.jstree",function(event){
					return true
				});
				$(document).on('click',"#"+this.container.attr("id")+" li",function(event){
					if(event.target.tagName!="LI") return true;
					if(event.pageY-$(event.target).offset().top>_this.li_height) return true;
					_this.toggle_branch.apply(_this,[event.target]);
					event.stopPropagation();
					return false
				});
				$(document).on("click.jstree","#"+this.container.attr("id")+" li a",function(event){
					if(event.which&&event.which==3) return true;
					_this.select_branch.apply(_this,[event.target,event.ctrlKey]);
					if(_this.inp){
						_this.inp.blur()
					}
					event.preventDefault();
					event.target.blur();
					return false
					obj.blur();
					event.preventDefault();
					event.stopPropagation();
					return false
				})
			},
			focus:function(){
				if(tree_component.focused!=this.cntr){
					tree_component.focused=this.cntr;
				}
			},
			scroll_check:function(x,y){
				var _this=this;
				var cnt=_this.container;
				var off=_this.container.offset();
				var st=cnt.scrollTop();
				var sl=cnt.scrollLeft();
				var h_cor=(cnt.get(0).scrollWidth>cnt.width())?40:20;
				if(y-off.top<20) cnt.scrollTop(Math.max((st-4),0));
				if(cnt.height()-(y-off.top)<h_cor) cnt.scrollTop(st+4);
				if(x-off.left<20) cnt.scrollLeft(Math.max((sl-4),0));
				if(cnt.width()-(x-off.left)<40) cnt.scrollLeft(sl+4);
			},
			get_node:function(obj){
				return $(obj).closest("li")
			},
			select_branch:function(obj){
				var _this=this;
				obj=_this.get_node(obj);
				if(!obj.size())return this.error("SELECT:NOT A VALID a");
				obj.children("a").removeClass("hover");
					if(this.selected){
						this.selected.children("A").removeClass("clicked");
					}
				this.selected=obj;
				this.selected.children("a").addClass("clicked").end().parents("li.closed").each(function(){
					_this.open_branch(this,true)
				});
				this.callback("onselect",[this.selected.get(0),_this]);
			},
			deselect_branch:function(obj){
				var _this=this;
				var obj=this.get_node(obj);
				if(obj.children("a.clicked").size()==0) return this.error("DESELECT:a NOT SELECTED");
				obj.children("a").removeClass("clicked");
			},
			toggle_branch:function(obj){
				var obj=this.get_node(obj);
				if(obj.hasClass("closed"))return this.open_branch(obj);
				if(obj.hasClass("open"))return this.close_branch(obj)
			},
			open_branch:function(obj,disable_animation,callback){
				var _this=this;
				var obj=this.get_node(obj);
				if(!obj.size())return this.error("OPEN:NO SUCH a");
				if(obj.hasClass("leaf"))return this.error("OPEN:OPENING LEAF a");
				if(obj.find("li").size()==0){
					obj.children("ul:eq(0)").remove().end().append('<ul class="nav"><li><i class="icon-load"></i> loading...</li></ul>');
					obj.removeClass("closed").addClass("open");
					var _datastore=new $.tree.datastores['json']();
					_datastore.load(this.callback("beforedata",[obj,this]),this,this.settings.data.opts,function(data){
						if(!data||data.length==0){
							obj.removeClass("closed").removeClass("open").addClass("leaf").children("ul").remove();
							if(callback) callback.call();
							return
						}
						_datastore.parse(data,_this,_this.settings.data.opts,function(str){
							obj.children("ul:eq(0)").replaceWith($("<ul class='nav'>").html(str));
							obj.find("li:last-child").end().find("li:has(ul)").not(".open").addClass("closed");
							obj.find("li").not(".open").not(".closed").addClass("leaf");
							_this.open_branch.apply(_this,[obj]);
							if(callback) callback.call()
						})
					});
					return true
				} else{
					obj.removeClass("closed").addClass("open");
					if(callback) callback.call()
					return true
				}
			},
			close_branch:function(obj,disable_animation){
				var _this=this;
				var obj=this.get_node(obj);
				if(!obj.size())return this.error("CLOSE:NO SUCH a");
				if(obj.hasClass("open"))obj.removeClass("open").addClass("closed")
			},
			parent:function(obj){
				obj=this.get_node(obj);
				if(!obj.size())return false;
				return obj.parents("li:eq(0)").size()?obj.parents("li:eq(0)"):-1
			},
			children:function(obj){
				if(obj===-1) return this.container.children("ul:eq(0)").children("li");
				obj=this.get_node(obj);
				if(!obj.size())return false;
				return obj.children("ul:eq(0)").children("li")
			},
			callback:function(cb,args){
				var p=false;
				var r=null;
				p=this.settings.callback[cb];
				if(typeof p=="function") return p.apply(null,args)
			},
			error:function(code){
				this.callback("error",[code,this]);
				return false
			}
		}
	};
	tree_component.inst={};
	$.extend($.tree.datastores,{
		"json":function(){
			return{
				get:function(obj,tree,opts){
					var _this=this;
					if(!obj||$(obj).size()==0) obj=tree.container.children("ul").children("li");
					else obj=$(obj);
					if(!opts) opts={};
					if(!opts.outer_attrib) opts.outer_attrib=["id","rel","class"];
					if(!opts.inner_attrib) opts.inner_attrib=[];
					if(obj.size()>1){
						var arr=[];
						obj.each(function(){
							arr.push(_this.get(this,tree,opts))
						});
						return arr
					}
					if(obj.size()==0) return [];
					var json={
						attributes:{},
						data:{}
					};
					if(obj.hasClass("open"))json.data.state="open";
					if(obj.hasClass("closed"))json.data.state="closed";
					for(var i in opts.outer_attrib){
						if(!opts.outer_attrib.hasOwnProperty(i))continue;
						var val=(opts.outer_attrib[i]=="class")?obj.attr(opts.outer_attrib[i]).replace(/(^| )last( |$)/ig," ").replace(/(^| )(leaf|closed|open)( |$)/ig," "):obj.attr(opts.outer_attrib[i]);
						if(typeof val!="undefined"&&val.toString().replace(" ","").length>0) json.attributes[opts.outer_attrib[i]]=val;
						delete val
					}
					var a=obj.children("a");
					if(opts.inner_attrib.length){
						json.data.attributes={};
						for(var j in opts.inner_attrib){
							if(!opts.inner_attrib.hasOwnProperty(j))continue;
							var val=a.attr(opts.inner_attrib[j]);
							if(typeof val!="undefined"&&val.toString().replace(" ","").length>0) json.data.attributes[opts.inner_attrib[j]]=val;
							delete val
						}
					}
					if(obj.children("ul").size()>0){
						json.children=[];
						obj.children("ul").children("li").each(function(){
							json.children.push(_this.get(this,tree,opts))
						})
					}
					return json
				},
				parse:function(data,tree,opts,callback){
					if(Object.prototype.toString.apply(data)==="[object Array]"){
						var str='';
						for(var i=0;i<data.length;i++){
							if(typeof data[i]=="function") continue;
							str+=this.parse(data[i],tree,opts)
						}
						if(callback) callback.call(null,str);
						return str
					}
					if(!data||!data.data){
						if(callback) callback.call(null,false);
						return ""
					}
					var str='<li ';
					var cls=false;
					if(data.attributes){
						for(var i in data.attributes){
							if(!data.attributes.hasOwnProperty(i))continue;
							str+=" "+i+"='"+data.attributes[i]+"' "
						}
					}
					if(!cls&&(data.state=="closed"||data.state=="open"))str+=" class='"+data.state+"' ";
					str+=">";
					var attr={};
					attr["href"]="";
					if((typeof data.data.attributes).toLowerCase()!="undefined"){
						for(var i in data.data.attributes){
							if(!data.data.attributes.hasOwnProperty(i))continue;
							attr[i]=data.data.attributes[i]
						}
					}
					str+='<a><i class="icon-folder-close"></i> ';
					str+=((typeof data.data.title).toLowerCase()!="undefined"?data.data.title:data.data)+"</a>"
					if(data.children&&data.children.length){
						str+='<ul class="nav">';
						for(var i=0;i<data.children.length;i++){
							str+=this.parse(data.children[i],tree,opts)
						}
						str+='</ul>'
					}
					str+="</li>";
					if(callback) callback.call(null,str);
					return str
				},
				load:function(data,tree,opts,callback){
					if(opts.static){
						callback.call(null,opts.static)
					} else{
						$.ajax({
							'type':'POST',
							'url':opts.url,
							'data':data,
							'dataType':"json",
							'success':function(d,textStatus){
								callback.call(null,d)
							},
							'error':function(xhttp,textStatus,errorThrown){
								callback.call(null,false);
								tree.error(errorThrown+' '+textStatus)
							}
						})
					}
				}
			}
		}
	})
})(jQuery);
$(document).ajaxError(function(event,xhr,ajaxSettings,thrownError){
	$('#notification').html($('<div>',{class:'alert alert-danger'}).html(thrownError+"\r\n"+xhr.statusText));
});
(function(){
	var special=$.event.special,uid1='D'+(+new Date()),uid2='D'+(+new Date()+1);
	special.scrollstart={setup:function(){var b,a=function(f){var c=this,d=arguments;if(b){clearTimeout(b)}else{f.type="scrollstart";$.event.handle.apply(c,d)}b=setTimeout(function(){b=null},special.scrollstop.latency)};$(this).bind("scroll",a).data(uid1,a)},teardown:function(){$(this).unbind("scroll",$(this).data(uid1))}};
	special.scrollstop={latency:0,setup:function(){var b,a=function(f){var c=this,d=arguments;if(b){clearTimeout(b)}b=setTimeout(function(){b=null;f.type="scrollstop";$.event.handle.apply(c,d)},special.scrollstop.latency)};$(this).bind("scroll",a).data(uid2,a)},teardown:function(){$(this).unbind("scroll",$(this).data(uid2))}};
})();
(function(e){var t;e.fn.ajaxUpload=function(n){var r=e.extend({accept:["*"],name:"file",method:"POST",url:"/",data:false,onSubmit:function(){return true},onComplete:function(){return true}},n);return this.each(function(){var n=e(this);n.css("position","relative");n.setData=function(e){r.data=e};var i=e('<form style="margin:0px !important;padding:0px !important;position:absolute;top:0px;left:0px;" method="'+r.method+'" enctype="multipart/form-data" action="'+r.url+'"> <input name="'+r.name+'" type="file" /></form>');var s=i.find("input[name="+r.name+"]");s.css("display","block");s.css("overflow","hidden");s.css("width","100%");s.css("height","100%");s.css("text-align","right");s.css("opacity","0");s.css("z-index","999999");s.change(function(t){i.find("input[type=hidden]").remove();r.onSubmit.call(n,e(this));if(r.data){e.each(r.data,function(t,n){i.append(e('<input type="hidden" name="'+t+'" value="'+n+'">'))})}i.submit();e(i).find("input[type=file]").attr("disabled","disabled")});e(n).append(i);if(!t){t=e('<iframe id="__ajaxUploadIFRAME" name="__ajaxUploadIFRAME"></iframe>').attr("style",'style="width:0px;height:0px;border:0px solid #fff;"').hide();t.attr("src","");e(document.body).append(t)}var o=function(){e(i).find("input[type=file]").removeAttr("disabled");var s=e(this).contents().find("html body").text();r.onComplete.call(n,s);t.unbind()};i.submit(function(e){t.load(o);i.attr("target","__ajaxUploadIFRAME");e.stopPropagation()})})}})(jQuery);
$(function(){
	$('#refresh').bind('click',function(){
		var tree=$.tree.focused();
		tree.refresh(tree.selected);
	});
});
function s(json){
	if(json.success){
		$('#dialog').modal('hide');
		var tree=$.tree.focused();
		tree.select_branch(tree.selected);
		$('#notification').html($('<div>',{class:'alert alert-success'}).html(json.success));
	}
	if(json.error){
		$('#notification').html($('<div>',{class:'alert alert-danger'}).html(json.error));
	}
}