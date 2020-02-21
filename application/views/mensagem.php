<!-- MOSTRA MENSAGENS VINDAS DE FUNÇÕES_HELPER-->
        <?php if($aviso = recupera_mensagem()): ?>          
          <!--CONFIGURA LAYOUT DA CAIXA DE MENSAGEM FALHA-->
          <?php if ($aviso['layout'] == 'falha'): ?>
            <div class="card  bg-danger round shadow my-3">
              <div class="card-body text-center text-white">
                <h2><i class="far fa-thumbs-down"></i></h2>            
                <p class="card-text">
                  <!--MOSTRA MENSAGEM-->
                 <?php echo $aviso['mensagem']; ?>                      
               </p>   
             </div>
           </div>
          <!--CONFIGURA LAYOUT DA CAIXA DE MENSAGEM SUCESSO-->             
         <?php elseif($aviso['layout'] == 'sucesso'): ?>        
           <div class="card  bg-success round shadow my-3">
             <div class="card-body text-center text-white">
               <h2><i class="far fa-thumbs-up"></i></h2>            
               <p class="card-text">
                <!--MOSTRA MENSAGEM-->
                <?php echo $aviso['mensagem']; ?>                            
              </p>   
            </div>
          </div>
          <!--CONFIGURA LAYOUT DA CAIXA DE MENSAGEM ALERTA-->             
         <?php elseif($aviso['layout'] == 'alerta'): ?>        
           <div class="card  bg-warning round shadow my-3">
             <div class="card-body text-center">
               <h2><i class="fas fa-exclamation-triangle"></i></i></h2>            
               <p class="card-text">
                <!--MOSTRA MENSAGEM-->
                <?php echo $aviso['mensagem']; ?>                            
              </p>   
            </div>
          </div>              
        <?php endif; ?>
      <?php endif; ?>