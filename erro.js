				//=== Erros ===
				$( ".erro" ).click(function() {
				  $(".erro").css('opacity', '0');
				  $(".erro").css('visibility', 'hidden');
				});
				$( "#center" ).click(function() {
				  $("#center").css('background', '#333');
				   $("#center").css('color', '#ccc');
				});

				function erro01(){
				  $(".erro").css('visibility', 'visible');
				  $(".erro").css('opacity', '1');
				}
				
				function erro02(){
				  $("#emailLog").css('background', 'rgb(245, 212, 212)');
				  $("#emailLog").css('border', '1px solid #e74c3c');
				  $("#email-error").css('display', 'block');
				}
				function erro03(){
				  $("#senhaLog").css('background', 'rgb(245, 212, 212)');
				  $("#senhaLog").css('border', '1px solid #e74c3c');
				  $("#pass-error").css('margin-top', '5px');
				  $("#pass-error").css('display', 'block');
				}
				function erro04(){
				  $("#center").css('background', '#F55B68');
				  $('#desc').fadeOut( 100 , function(){
					   var div = $('<div id="desc">The characters: \ / : * ? " < > |, cannot be used on the access code.</div>').hide();
					   $(this).replaceWith(div);
					   $('#desc').fadeIn( 500 );
				  });
				  $("#center").css('color', '#ffffff');
				}
				function erro07(){
				  $("#novoEmail").css('background', 'rgb(245, 212, 212)');
				  $("#novoEmail").css('border', '1px solid #e74c3c');
				  $("#name-error").css('display', 'block');
				}
				function erro08(){
				  $("#novoEmail02").css('background', 'rgb(245, 212, 212)');
				  $("#novoEmail02").css('border', '1px solid #e74c3c');
				  $("#email-error").css('display', 'block');
				}
				function erro09(){
				  $("#novaSenha-ant").css('background', 'rgb(245, 212, 212)');
				  $("#novaSenha-ant").css('border', '1px solid #e74c3c');
				  $("#pass-error").css('display', 'block');
				  $("#boxSenha").css('height', '280px');
				}
				function erro10(){
				  $("#novaSenha").css('background', 'rgb(245, 212, 212)');
				  $("#novaSenha").css('border', '1px solid #e74c3c');
				  $("#pass-error02").css('display', 'block');
				  $("#boxSenha").css('height', '280px');
				}
				$( ".erro" ).click(function() {
				  $(".erro").css('opacity', '0');
				  $(".erro").css('visibility', 'hidden');
				});
				function erro11(){
				  $(".erro").css('visibility', 'visible');
				  $(".erro").css('opacity', '1');
				}
				
				function erro14(){
				  $("#email-cc").css('background', 'rgb(245, 212, 212)');
				  $("#email-cc").css('border', '1px solid #e74c3c');
				  $("#email-error").css('display', 'block');
				}
				function erro12(){
				  $(".erro").css('visibility', 'visible');
				  $(".erro").css('opacity', '1');
				}
				function erro13(){
				  $("#name-cc").css('background', 'rgb(245, 212, 212)');
				  $("#name-cc").css('border', '1px solid #e74c3c');
				  $("#name-error").css('display', 'block');
				}
				function erro15(){
				  $("#email-cc").css('background', 'rgb(245, 212, 212)');
				  $("#email-cc").css('border', '1px solid #e74c3c');
				  $("#email-error2").css('display', 'block');
				}
				function erro16(){
				  $("#pass-cc").css('background', 'rgb(245, 212, 212)');
				  $("#pass-cc").css('border', '1px solid #e74c3c');
				  $("#pass-error").css('display', 'block');
				}
