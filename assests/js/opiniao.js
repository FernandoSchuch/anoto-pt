$(document).ready( function() {
    
    $("#formEmail").submit(function (event){
        event.preventDefault(); // Evita que o action padrão seja disparado (Busca/getNodos)        
        var vUrl   = $('#formEmail').attr('action');
        var vEmail = $('#edEmail').val();
        document.getElementById("emailAtual").setAttribute("value", vEmail);
        if (vEmail == '')
            alert('Email inválido');
        else {
            $.ajax({
                type : "post",
                url  : vUrl,
                data : {email: vEmail},
                success: function (retorno) {
                    $("#conteudo").empty().append(retorno);
                    window.scrollTo(0, 0);
                }
            });
        }
    });
    
    $("#formVol").submit(function (event){
        event.preventDefault(); // Evita que o action padrão seja disparado (Busca/getNodos)   
        var vUrl   = $('#formVol').attr('action');
        var vEmail = $('#edAddEmail').val();
        var vQuant = $('#edAddQuant').val();
        if (vEmail == ''){
            alert('Informe o e-mail');
        } else if (vQuant == ''){
            alert('Informe a quantidade de reviews novas');
        } else {
            $.ajax({
                type : "post",
                url  : vUrl,
                data : {email: vEmail, 
                        quant: vQuant},
                success: function (retorno) {
                    alert('Novo voluntário inserido no grupo '+ retorno + '.');
                    window.scrollTo(0, 0);
                }
            });
        }
            
    });
    
    $("#formVinc").submit(function (event){
        event.preventDefault(); // Evita que o action padrão seja disparado (Busca/getNodos)        
        var vUrl   = $('#formVinc').attr('action');
        var vGrupo   = $('#edVincGrupo').val();
        var vEmail   = $('#edVincEmail').val();
        if (vEmail == ''){
            alert('Informe o e-mail');
        } else if (vGrupo == ''){
            alert('Informe o grupo');
        } else {
            $.ajax({
                type : "post",
                url  : vUrl,
                data : {email: vEmail, 
                        grupo: vGrupo},
                success: function (retorno) {
                    alert('Novo voluntário vinculado.');
                    window.scrollTo(0, 0);
                }
            });
        }
    });
    
    $(document).on('click', '#btnResultados', function (event){
        event.preventDefault(); // Evita que o action padrão seja disparado (Busca/getNodos)        
        var vUrl   = $('#btnResultados').attr('livesite');        
        alert(vUrl);
        $.ajax({
            type : "post",
            url  : vUrl,
            success: function (retorno) {
                alert(retorno);
                $("#resultados").empty().append("<p>"+retorno+"<p>");
            }
        });
    });
    
    $(document).on('submit', '#formComecar', function (event){
        event.preventDefault(); // Evita que o action padrão seja disparado (Busca/getNodos)        
        var vUrl   = $('#formComecar').attr('action');        
        var vEmail = $('#emailAtual').val();
        $.ajax({
            type : "post",
            url  : vUrl,
            data : {email: vEmail},
            success: function (retorno) {
                //alert(retorno);
                $("#conteudo").empty().append(retorno);
                window.scrollTo(0, 0);
            }
        });
    });
    
    $(document).on('submit', '#formResposta', function (event){
        event.preventDefault(); // Evita que o action padrão seja disparado (Busca/getNodos)        
        setResposta(false);
    });
    
    $(document).on('click', '#btFinalizar', function (event){
        event.preventDefault(); // Evita que o action padrão seja disparado (Busca/getNodos)        
        if (document.querySelector('input[name="resposta"]:checked'))
            setResposta(true);
        $.ajax({
            type : "post",
            url  : $("#btFinalizar").attr('livesite'),
            success: function (retorno) {
                $("#conteudo").empty().append(retorno);
                window.scrollTo(0, 0);
            }
        });
    });
    
    function setResposta(finalizando){
        var vUrl   = $('#formResposta').attr('action');
        var vEmail = $('#emailAtual').val();
        if (!document.querySelector('input[name="resposta"]:checked'))
            alert("Por favor, selecione uma das classificações disponíveis.");
        else {
            $.ajax({
                type : "post",
                url  : vUrl,
                data : {email: vEmail, 
                        review: $('#revId').val(),
                        resposta: document.querySelector('input[name="resposta"]:checked').value},
                success: function (retorno) {
                    if (!finalizando){
                        $.ajax({
                            type : "post",
                            url  : retorno,
                            data : {email: vEmail},
                            success: function (ret) {
                                $("#conteudo").empty().append(ret);
                                window.scrollTo(0, 0);
                            }
                        });
                    }
                }
            });
        }
    }
});