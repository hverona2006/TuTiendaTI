$(document).ready(function() {
  var cc=parseInt($("#cc").text());
  var chk=document.getElementById('terminos');
  if(chk){
    if(chk.checked){
      chk.checked=false; // Ajuste para glitch en Chrome
    }
  }
  var prod=0;
  var cant=0;
  var ext=0;
  var st=0;
  var datos={};
  var arrC=[];

  bootbox.setLocale("es");

  jQuery.validator.setDefaults({
    highlight: function(element) {
      jQuery(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
    },
    unhighlight: function(element) {
      jQuery(element).closest('.form-control').removeClass('is-invalid').addClass('is-valid');
    },
    errorElement: 'span',
    errorClass: 'invalid-feedback',
    errorPlacement: function(error, element) {
      if(element.parent('.input-group').length) {
        error.insertAfter(element.parent());
      } else {
        error.insertAfter(element);
      }
    }
  });


  jQuery.validator.addMethod("emailOnly", function(value,element){
    var input= /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,6})+$/;
    return this.optional(element) || input.test(value);
  },"Por favor, escribe una dirección de correo válida.");


  var pr=document.getElementById("principal");
  if(pr!=null){
    consulta("inicio.php",{},function(pag){
      $("#principal").html(pag);
      $("#cc").text(cc);
    });
  }


  $(document).on("keypress","#pw",function(event){
    var e= event.keyCode;
    if(e==13){
      $("#form-login").validate({
        rules:{
          user:{required:true},
          pw:{required:true}
        }
      });
      if($("#form-login").valid()){
        datos={
          user:$("#user").val(),
          pw:$("#pw").val()
        };
        transaccion("php/login.php",datos,function(res){
          if(res==true){
            consulta("pag/admin/admin-main.php",{},function(pag){
              bootbox.alert({
                title:"Has ingresado",
                message: "La sesión ha iniciado correctamente.",
                centerVertical: true,
                callback: function(){
                  $(".admin-main").html(pag);
                  $("nav a.inicio").attr('hidden','hidden');
                  $(".adminsesion").attr('hidden','hidden');
                  $(".logout").removeAttr('hidden');
                  $(".productos").removeAttr('hidden');
                  $(".pedidos").removeAttr('hidden');
                }
              });
            });
          }else{
            bootbox.alert({
              title:"Error",
              message: "Error al iniciar sesión. Verifica tus datos e intenta nuevamente.",
              centerVertical: true
            });
          }
        });
      }else{
        return false;
      }
    }
  });


  // $(document).on("click","#register-u",function(){
  //   consulta("pag/register.html",{},function(pag){
  //     $("#principal").html(pag);
  //   });
  // });
  //
  // $(document).on("click","#login-u",function(){
  //   consulta("pag/login.html",{},function(pag){
  //     $("#principal").html(pag);
  //   });
  // });

  $(document).on("click","#veriflogin-a",function(){
    $("#form-login").validate({
      rules:{
        user:{required:true},
        pw:{required:true}
      }
    });
    if($("#form-login").valid()){
      datos={
        user:$("#user").val(),
        pw:$("#pw").val()
      };
      transaccion("php/login.php",datos,function(res){
        if(res==true){
          consulta("pag/admin/admin-main.php",{},function(pag){
            bootbox.alert({
              title:"Has ingresado",
              message: "La sesión ha iniciado correctamente.",
              centerVertical: true,
              callback: function(){
                $(".admin-main").html(pag);
                $("nav a.inicio").attr('hidden','hidden');
                $(".adminsesion").attr('hidden','hidden');
                $(".logout").removeAttr('hidden');
                $(".productos").removeAttr('hidden');
                $(".pedidos").removeAttr('hidden');
              }
            });
          });
        }else{
          bootbox.alert({
            title:"Error",
            message: "Error al iniciar sesión. Verifica tus datos e intenta nuevamente.",
            centerVertical: true
          });
        }
      });
    }else{
      return false;
    }
  });

  $(document).on("click",".logout",function(){
    transaccion("php/logout.php",{},function(res){
      if(res==true){

        bootbox.alert({
          title:"Has salido",
          message: "La sesión ha cerrado correctamente.",
          centerVertical: true,
          callback: function(){
            $(".logout").attr('hidden','hidden');
            $(".adminsesion").removeAttr('hidden');
            $("nav a.inicio").removeAttr('hidden');
            $(".productos").attr('hidden','hidden');
            $(".pedidos").attr('hidden','hidden');
            setTimeout(location.reload(),1000);
          }
        });
      }else{
        bootbox.alert({
          title:"Error",
          message: "Error al salir de la sesión. Intenta nuevamente.",
          centerVertical: true
        });
      }
    });
  });

  $(document).on("click",".productos",function(){
    consulta("pag/admin/admin-prods.php",{},function(pag){
      $(".contenido").html(pag);
      consulta("pag/admin/filtro-pr-all.php",{},function(res){
        $(".filtro-prods").html(res);
        $("#filtro").html("Todos los productos");
      });
    });
  });

  $(document).on("click","#todos",function(){
    $("#filtro").html("Todos los productos");
    consulta("pag/admin/filtro-pr-all.php",{},function(res){
      $(".filtro-prods").html(res);
    });
  });

  $(document).on("click","#activos",function(){
    $("#filtro").html("Productos activos");
    consulta("pag/admin/filtro-pr-act.php",{},function(res){
      $(".filtro-prods").html(res);
    });
  });

  $(document).on("click","#ctg",function(){
    var nomcat=$(this).text();
    $("#filtro").html("Categoría: "+nomcat);
    transaccion("pag/admin/filtro-pr-ctg.php",{cat:$(this).val()},function(res){
      $(".filtro-prods").html(res);
    });
  });

  $(document).on("click","#activo",function(){
    var act=document.getElementById("activo");
    var x = +act.checked;
    var ini=document.getElementById("inicio");
    if(!x){
      ini.checked=false;
      $('#inicio').attr('disabled','disabled');
    }else{
      $('#inicio').removeAttr('disabled');
    }
  });

  $(document).on("click",".nuevo-prod",function(){
    consulta("pag/admin/nuevo-prod.php",{}, function(result){
      bootbox.dialog({
        title:"Registrar nuevo producto",
        message:result,
        buttons:{
          success:{
            label:"<span class='icon-save'></span> Guardar",
            className:"btn-success",
            callback:function(){
              $("#formNuevoProd").validate({
                rules:{
                  nombre:{required:true},
                  precio:{required:true,number:true, min:1},
                  existencias:{required:true,number:true, min:1},
                  descripcion:{required:true},
                }
              });

              var up=false;
              var ph=document.querySelectorAll("input[type=file]");
              var ic=[];
              for (var i = 0; i < ph.length; i++) {
                var f = ph[i].files;
                if(i==0){
                  if(f.length!=0){
                    ic.push($(ph[i]).attr("data-order"));
                    up=true;
                  }else{
                    up=false;
                    i=ph.length;
                  }
                }
                if(f.length!=0 && i!=0){
                  ic.push($(ph[i]).attr("data-order"));
                }
              }

              if($("#formNuevoProd").valid() && up==true){
                var act=document.getElementById("activo");
                var ini=document.getElementById("inicio");
                datos={
                  cat:$("#cat").val(),
                  nombre:$("#nombre").val(),
                  precio:$("#precio").val(),
                  existencias:$("#existencias").val(),
                  descripcion:$("#descripcion").val(),
                  activo:+act.checked,
                  inicio:+ini.checked,
                };

                  var fd = new FormData();
                  for (var z = 0; z < ic.length; z++) {
                    var pos=ic[z];
                    var inps = document.getElementById('fotos'+pos);
                    var fls = inps.files;
                    fd.append(z,fls[0]);
                  }

                  for(var value of fd.entries()) {
                    console.log(value);
                  }

                transaccion("php/admin/insert-prod.php",datos, function(){
                  $.ajax({
                    url : "php/admin/insert-ph.php",
                    method : "POST",
                    data: fd,
                    contentType:false,
                    processData:false
                  });
                  consulta("pag/admin/admin-prods.php",{},function(result){
                    $(".contenido").html(result);
                    consulta("pag/admin/filtro-pr-all.php",{},function(res){
                      $(".filtro-prods").html(res);
                    });
                  });
                });
              }else{
                alert("Falta algún dato o la foto principal.");
                if(ph[0].files.length==0){
                  $('#fprinc').addClass("text-danger").append(" (!)");
                }else{
                  $('#fprinc').removeClass("text-danger");
                  var txt=$('#fprinc').text();
                  txt=txt.replace(" (!)","");
                  $('#fprinc').html("").append(txt);
                }
                return false;
              }
            }
          }
        }
      });
    });
  });

  $(document).on("click",".editar-prod",function(){
    datos={
      idprod: $(this).attr("data-idprod"),
      cat:$(this).attr("data-cat")
    };
    consulta("pag/admin/editar-prod.php",datos, function(result){
      bootbox.dialog({
        title:"Editar producto",
        message:result,
        buttons:{
          success:{
            label:"<span class='icon-save'></span> Guardar",
            className:"btn-success",
            callback:function(){
              $("#formEditarProd").validate({
                rules:{
                  nombre:{required:true},
                  precio:{required:true,number:true, min:1},
                  existencias:{required:true,number:true, min:1},
                  descripcion:{required:true},
                }
              });
              if($("#formEditarProd").valid()){
                var act=document.getElementById("activo");
                var ini=document.getElementById("inicio");
                datos={
                  idprod:$("#idprod").val(),
                  cat:$("#cat").val(),
                  nombre:$("#nombre").val(),
                  precio:$("#precio").val(),
                  existencias:$("#existencias").val(),
                  descripcion:$("#descripcion").val(),
                  activo:+act.checked,
                  inicio:+ini.checked,
                };
                // var archivos = document.getElementById("fotos");
                // var archivo = archivos.files;
                // var archivos = new FormData();
                // for(i=0; i<archivo.length; i++){
                //   archivos.append(i,archivo[i]);
                // }
                bootbox.confirm("¿Está seguro de actualizar los datos de este producto?", function(val){
                  if(val==true){
                    transaccion("php/admin/update-prod.php",datos, function(sql){
                      // $.ajax({
                      //   url : "php/admin/update-ph.php",
                      //   method : "POST",
                      //   data: archivos,
                      //   contentType:false,
                      //   processData:false
                      // });
                      consulta("pag/admin/admin-prods.php",{},function(result){
                        $(".contenido").html(result);
                        consulta("pag/admin/filtro-pr-all.php",{},function(res){
                          $(".filtro-prods").html(res);
                        });
                      });
                    });
                  }
                });
              }else{
                return false;
              }
            }
          }
        }
      });
    });
  });

  $(document).on("click",".pedidos",function(){
    consulta("pag/admin/admin-peds.php",{},function(pag){
      $(".contenido").html(pag);
      consulta("pag/admin/filtro-pd-all.php",{},function(res){
        $(".filtro-peds").html(res);
        $("#filtro-pd").html("Todos los pedidos");
      });
    });
  });

  $(document).on("click","#ped-all",function(){
    $("#filtro-pd").html("Todos los pedidos");
    consulta("pag/admin/filtro-pd-all.php",{},function(res){
      $(".filtro-peds").html(res);
    });
  });

  $(document).on("click","#ped-est",function(){
    var catped=$(this).text();
    $("#filtro-pd").html("Pedidos "+catped);
    consulta("pag/admin/filtro-pd-est.php",{est:$(this).val()},function(res){
      $(".filtro-peds").html(res);
    });
  });

  $(document).on("click","#it-ped",function(){
    var idped = $(this).attr('data-idped');
    consulta("pag/admin/it-ped.php",{idped:idped},function(res){
      bootbox.alert({
        title:"Detalles del pedido",
        size:"lg",
        message: res,
        centerVertical: true
      });
    });
  });

  $(document).on("click",".cam-est",function(){
    var btn=$(this);
    var est=btn.val();
    var te="";
    switch (est) {
      case "0":
      te="Cancelado/Devuelto";
      break;
      case "1":
      te="Pendiente de envío";
      break;
      case "2":
      te="Enviado";
      break;
    }
    bootbox.confirm("¿Está seguro de cambiar el estado de este pedido a '"+te+"'?", function(val){
      if(val==true){
        var ref=btn.attr("data-ref");
        datos={
          est:est,
          idped:btn.attr('data-idped')
        }
        transaccion("php/admin/cam-est.php",datos,function(res){
          if(res){
            bootbox.alert({
              title:"¡Estado cambiado!",
              message: "El estado del pedido con referencia "+ref+" ha sido modificado a '"+te+"'",
              centerVertical: true,
              callback: function(){
                consulta("pag/admin/admin-peds.php",{},function(pag){
                  $(".contenido").html(pag);
                  consulta("pag/admin/filtro-pd-all.php",{},function(res){
                    $(".filtro-peds").html(res);
                    $("#filtro-pd").html("Todos los pedidos");
                  });
                });
              }
            });
          }else{
            bootbox.alert({
              title:"Error",
              message: "Error al intentar modificar el estado del pedido. Contacte a soporte técnico.",
              centerVertical: true
            });
          }
        });
      }
    });
  });

  $(document).on("click","#menos",function(){
    prod=$(this).val();
    cant=parseInt($("#cant-"+prod).val());
    if(cant>1){
      cant-=1;
      $("#cant-"+prod).val(cant);
    }
  });

  $(document).on("click","#mas",function(){
    prod=$(this).val();
    cant=parseInt($("#cant-"+prod).val());
    ext=parseInt($("#ex").val());
    if(cant<ext){
      cant+=1;
      $("#cant-"+prod).val(cant);
    }else{
      bootbox.alert({
        title:"¿Lo quieres todo?",
        message: "Has llegado al límite de existencias de este producto.",
        centerVertical: true
      });
    }
  });

  $(document).on("click",".addcart",function(){
    prod=$(this).val();
    cant=$("#cant-"+prod).val();
    st=($("#price-"+prod).val())*cant;
    datos={
      prod:prod,
      cant:cant,
      st:st,
    };
    transaccion("php/addcart.php",datos,function(n){
      if(n){
        cc+=1;
        $("#cc").text(cc);
        bootbox.alert({
          title:"Agregado",
          message: "Producto agregado al carrito.",
          centerVertical: true
        });
      }else{
        bootbox.alert({
          title:"Ya lo tienes.",
          message: "El producto ya está en el carrito. Cantidad actualizada.",
          centerVertical: true
        });
      }
    });
  });

  $(document).on("click",".addcart-s",function(){
    prod=$(this).val();
    cant=$("#cant-"+prod).val();
    st=($("#price-"+prod).val())*cant;
    datos={
      prod:prod,
      cant:cant,
      st:st,
    };
    transaccion("../php/addcart.php",datos,function(n){
      if(n){
        cc+=1;
        $("#cc").text(cc);
        bootbox.alert({
          title:"Agregado",
          message: "Producto agregado al carrito.",
          centerVertical: true
        });
      }else{
        bootbox.alert({
          title:"Ya lo tienes.",
          message: "El producto ya está en el carrito. Cantidad actualizada.",
          centerVertical: true
        });
      }
    });
  });

  $(document).on("click",".elim-prod",function(){
    prod = $(this).attr('data-prod');
    transaccion("../php/removecart.php",{prod:prod},function(rm){
      if(rm){
        cc-=1;
        $("#cc").text(cc);
        location.reload();
      }else{
        bootbox.alert({
          title:"Error.",
          message: "Error al eliminar.",
          centerVertical: true
        });
      }
    });
  });

  $(document).on("click",".emptycart",function(){
    transaccion("../php/emptycart.php",{},function(){
      location.reload();
    });
  });

  $(document).on("submit", ".reg-email", function(e) {
    e.preventDefault();
    $(".btn-info").click();
});

  $(document).on("click","#ir-pagar",function(){
    consulta("reg-email.html",{},function(pag){
      bootbox.dialog({
        centerVertical: true,
        onEscape: true,
        title: "Por favor, ingresa tu correo electrónico",
        message: pag,
        buttons:{
          success:{
            label:"<span class='icon-check'></span> Iniciar",
            className:"btn-info",
            callback:function(){
              $('.reg-email').validate({
                rules:{
                  email:{required:true,emailOnly:true},
                }
              });
              if($('.reg-email').valid()){
                var em=$('#email').val();
                transaccion("../php/info-e.php",{email:em},function(){
                  setTimeout(function(){
                    location.href='checkout#datos-facturacion';
                  }, 1000);
                });
              }else{
                return false;
              }
            }
          },
          cancel:{
            label:"<span class='icon-back'></span> Cancelar",
            className:"btn-danger"
          }
        }
      });
    });
  });

  $("#dep").change(function() {
    consulta("../php/cons-muns.php",{id_dep:$("#dep").val()},function(res){
      $("#mun").html(res);
      $("#mun").val=1;
    });
  });

  var fco=document.getElementById('formCheckout');
  if(fco!=null){
    var em=$('#email').val();
    if(em!=''){
      transaccion("../php/cons-dat.php",{email:em},function(res){
        if(res!="nothing"){
          arrC=res.split(",");
          $('#doc').val(arrC[0]);
          $('#nombre').val(arrC[1]);
          $('#tel').val(arrC[2]);
          $('#dir').val(arrC[3]).keyup();
          $('#dep').val(parseInt(arrC[4])).change();
          setTimeout(function(){
            $('#mun').val(parseInt(arrC[5])).change();
          }, 1000);
          $('#email').attr('readonly','readonly');
          $('#doc').attr('disabled','disabled');
          $('#nombre').attr('disabled','disabled');
          bootbox.alert({
            title: "¡Bienvenido de vuelta, "+arrC[1]+"!",
            message: "Completamos los datos por ti.<br /><strong>Actualiza alguno si lo ves necesario.</strong>",
            centerVertical: true
          });
        }
      });
    }
  }

  $(document).on("click","#terminos",function(){
    var trm=document.getElementById('terminos');
    if (trm.checked) {
      $('#ir-pagar').removeClass('disabled');
    }else{
      $('#ir-pagar').addClass('disabled');
    }
  });

  $(document).on("focusout","#doc",function(){
    if($(this).val()!=""){
      transaccion("../php/cons-dat.php",{doc:$(this).val()},function(res){
        if(res!="nothing"){
          arrC=res.split(",");
          $('#nombre').val(arrC[1]);
          $('#tel').val(arrC[2]);
          $('#dir').val(arrC[3]).keyup();
          $('#dep').val(parseInt(arrC[4])).change();
          setTimeout(function(){
            $('#mun').val(parseInt(arrC[5])).change();
          }, 1000);
          $('#email').attr('readonly','readonly');
          $('#doc').attr('disabled','disabled');
          $('#nombre').attr('disabled','disabled');
          bootbox.alert({
            title: "¡Bienvenido de vuelta, "+arrC[1]+"!",
            message: "Completamos los datos por ti.<br /><strong>Actualiza alguno si lo ves necesario.</strong>",
            centerVertical: true
          });
        }
      });
    }
  });

  $(document).on("click","#confirmar",function(){
    $("#formCheckout").validate({
      rules:{
        email:{required:true,emailOnly:true},
        nombre:{required:true},
        apellidos:{required:true},
        doc:{required:true,number:true, maxlength:13},
        tel:{required:true,number:true, minlength:10,maxlength:10},
        dep:{required:true},
        mun:{required:true},
        dir:{required:true},
        terminos:{required:true}
      }
    });

    if($("#formCheckout").valid()){
      bootbox.confirm("¿Estás seguro?", function(val){
        if(val==true){
          var sm=$("#mun option:selected").text();
          var sd=$("#dep option:selected").text();
          datos={
            email:$('#email').val(),
            doc:parseInt($('#doc').val()),
            nombre:$('#nombre').val(),
            tel:$('#tel').val(),
            dep:$('#dep').val(),
            mun:$('#mun').val(),
            dir:$('#dir').val(),
          };
          arrDP=[$('#nombre').val(),$('#tel').val(),$('#dir').val(),$('#email').val()];
          transaccion("../php/datosclientebd.php",datos,function(res){
            if(res==true){
              $('#datos-fac').attr('disabled','disabled');
              $('#confirmar').attr('disabled','disabled').removeClass('btn-info').addClass('btn-success').html('<span class="icon-check"></span> Datos de facturación confirmados');
              bootbox.alert({
                title:"Datos confirmados",
                message:"Tus datos han sido confirmados",
                centerVertical: true,
                callback: function(){
                  transaccion("../pag/payu-datos.php",{},function(res){
                    $('.dat-fac').html(res);
                    location.hash="resumen";
                    $('#nombre').text(arrDP[0]);
                    $('#tel').text(arrDP[1]);
                    $('#dir').text(arrDP[2]+' - '+sm+', '+sd);
                    $('#shippingAddress').val(arrDP[2]);
                    $('#shippingCity').val(sm);
                  });
                }
              });
            }else{
              bootbox.alert({
                title:"Error",
                message: "Error al registrar los datos. Intenta nuevamente.",
                centerVertical: true
              });
            }
          });
        }
      });
    }else{
      bootbox.alert({
        title:"Algo anda mal...",
        message: "Verifica tus datos e intenta nuevamente.",
        centerVertical: true
      });
      return false;
    }

  });
});

function consulta(url,param,resp){
  $.ajax({
    type:"get",
    url:url,
    data:param,
    success:resp
  });
}

function transaccion(url,param,resp){
  $.ajax({
    type:"post",
    url:url,
    data:param,
    success: resp
  });
}


function cargarPrincipalAdmin(){
  consulta("pag/admin/admin-main.php",{},function(result){
    $(".admin-main").html(result);
    $("nav a.inicio").attr('hidden','hidden');
    $(".adminsesion").attr('hidden','hidden');
    $(".logout").removeAttr('hidden');
    $(".productos").removeAttr('hidden');
    $(".pedidos").removeAttr('hidden');
  });
}
