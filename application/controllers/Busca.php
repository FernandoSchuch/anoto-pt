<?php
if(! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed - busca' );
error_reporting(0);
class Busca extends CI_Controller {	
        
	public function __construct() {
            parent::__construct();
            $this->load->model('reviewmodel');
	}
	
        public function getInstrucoes(){
            $parametros = $this->input->post();
            if ($this->reviewmodel->getReviewsFaltantes($parametros['email']) > 0) {
                echo '<div>
                        <h3>Instruções</h3>
                        <p>
                            Assista ao vídeo abaixo para receber as instruções sobre como utilizar a ferramenta.<br><br>
                            <iframe src="https://www.youtube.com/embed/4KXjNDV37b4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <br><br>
                            <form action="'. base_url() .'index.php/Busca/getReview" id="formComecar" method="post" >
                                <button type="submit" class="btn btn-success">Começar</button>    
                            </form>
                        </p>
                      </div>';
            } else {
                echo '<div>
                        <h3>Opa! Você não tem opiniões a serem avaliadas</h3>
                        <p>
                            Se você quer contribuir com a minha pesquisa, por favor, entre em contato comigo através do meu e-mail que está no final da página.
                        </p>
                      </div>';
                
            }
	}
        
	public function getReview(){            
            $parametros = $this->input->post();
            $faltam = $this->reviewmodel->getReviewsFaltantes($parametros['email']);
            if ($faltam > 0) {
                $dados      = $this->reviewmodel->getNextReview($parametros['email']);
                echo '<div class="card" style="margin-top: 20px">
                        <div class="card-header">
                            <b>Categoria:</b> '. $dados['rev_categoria'] .' <br> 
                            <b>Produto:</b> '. $dados['rev_produto'] .'
                            <input type="hidden" id="revId" value="'. $dados['rev_id'] .'"/>   
                        </div>
                        <div class="card-body">
                            <p class="div-opiniao rounded">"'. $dados['rev_opiniao'] .'"</p>
                            <form action="'. base_url() .'index.php/Busca/setResposta" id="formResposta" method="post">
                                <div class="container">
                                    <div class="row div-radio">
                                        <div>
                                            <input id="radio1" type="radio" name="resposta" value="P" />
                                        </div>
                                        <div class="div-label">
                                            <label for="radio1"> Possui, utilizou ou conhece alguém que possui ou utilizou o produto</label>
                                        </div>                                    
                                    </div>
                                    <div class="row div-radio">
                                        <div>
                                            <input id="radio2" type="radio" name="resposta" value="N" />
                                        </div>
                                        <div class="div-label">
                                            <label for="radio2"> Não possui nem utilizou o produto</label><br>
                                        </div>
                                    </div>
                                    <div class="row div-radio">
                                        <div>
                                            <input id="radio3" type="radio" name="resposta" value="D" />
                                        </div>
                                        <div class="div-label">
                                            <label for="radio3"> Não há como afirmar </label>
                                        </div><br>
                                    </div>
                                    <div class="row div-radio">
                                        <div>
                                            <input id="radio4" type="radio" name="resposta" value="R" />
                                        </div>
                                        <div class="div-label">
                                            <label for="radio4"> Não está relacionado ao produto</label>
                                        </div>
                                    </div>
                                </div><br>
                                <button type="button" class="btn btn-link" style="padding-left: 0px" data-toggle="modal" data-target="#modalInstrucoes">Ver Instruções</button><br>
                                <button type="submit" class="btn btn-success"><i class="fas fa-arrow-right"></i>  Próxima</button>
                                <p style="float: right">Faltam: '.$faltam.'</p>
                                <!--<button class="btn btn-danger" id="btFinalizar" livesite="'. base_url() .'index.php/Busca/finalizar" style="float: right"><i class="fas fa-door-open"></i>  Finalizar</button>-->
                            </form>
                        </div>
                        <div class="modal" id="modalInstrucoes">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">'.
                                        $this->getExplicao()
                                    .'</div>
                                    <div class="modal-footer rodape-modal">
                                        <span>'. $dados['coh_titulo'] .'</span>                                    
                                        <button  type="button" class="btn btn-success" style="float: right" data-dismiss="modal">OK</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>';
            } else {
                echo '<div>
                        <h3>Você não tem mais opiniões a serem avaliadas</h3>
                        <p>
                            Obrigado por participar da minha pesquisa. Se você deseja contribuir ainda mais, por favor, entre em contato comigo através do meu e-mail que está no final da página.
                        </p>
                      </div>';
            }
	}
        
        public function setResposta(){            
            $parametros = $this->input->post();
            
            $this->reviewmodel->setRepostaReview($parametros['email'], $parametros['review'], $parametros['resposta']);
            echo base_url() . 'index.php/Busca/getReview';
	}
        
        public function finalizar(){            
            echo '<div>
                    <h3>Obrigado!</h3>
                    <p>
                        Agradeço pela tua participação.<br><br>
                        Se possível, compartilhe o link desta página com amigos. Quanto mais pessoas ajudarem, menos opiniões tendenciosas teremos nos sites de venda.
                    </p>
                  </div>';
	}
        
        public function getExplicao(){
            return '<div>
                        <h3>Instruções</h3>
                            <iframe src="https://www.youtube.com/embed/4KXjNDV37b4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                      </div>';
        }
        
        public function adicionaVoluntario() {
            $parametros = $this->input->post();
            echo $this->reviewmodel->addVoluntario($parametros['email'], $parametros['quant']);
        }
        
        public function vinculaVoluntario(){
            $parametros = $this->input->post();
            $this->reviewmodel->vinculaVoluntario($parametros['email'], $parametros['grupo']);
        }
        
        public function getResultados(){
            $grupos = array('3, 7, 17',
                            '4, 6, 14',
                            '5, 19',
                            '8',
                            '9',
                            '10',
                            '11',
                            '12',
                            '13, 21',
                            '15',
                            '16',
                            '18',
                            '20',
                            '22');
            
            /*      Matriz de Confusão         
             *             J2
             *       __P___N___D___R__ 
             *     P| PP  pn  pd  pr | n0
             * J1  N| np  NN  nd  nr | n1
             *     D| dp  dn  DD  dr | n2
             *     R| rp  rn  rd  RR | n3
             *       --------------------- 
             *        m0  m1  m2  m3 | total 
             */
            foreach ($grupos as $i){
                $retorno  = $this->reviewmodel->getResultados($i);
                $jurado1  = true;
                $resposta = 'A';

                $pp = 0;
                $pn = 0;
                $pd = 0;
                $pr = 0;
                //
                $np = 0;
                $nn = 0;
                $nd = 0;
                $nr = 0;
                //
                $dp = 0;
                $dn = 0;
                $dd = 0;
                $dr = 0;
                //
                $rp = 0;
                $rn = 0;
                $rd = 0;
                $rr = 0;


                $total = 0;
                foreach ($retorno as $registro) {
                    if ($jurado1) {
                        $resposta = $registro['ava_resposta'];
                        $total++;
                    } else {
                        switch ($resposta) {
                            case 'P':
                                switch ($registro['ava_resposta']) {
                                    case 'P': ++$pp; break;
                                    case 'N': ++$pn; break;
                                    case 'D': ++$pd; break;
                                    case 'R': ++$pr; break;
                                }
                                break;
                            case 'N': 
                                switch ($registro['ava_resposta']) {
                                    case 'P': ++$np; break;
                                    case 'N': ++$nn; break;
                                    case 'D': ++$nd; break;
                                    case 'R': ++$nr; break;
                                }
                                break;
                            case 'D': 
                                switch ($registro['ava_resposta']) {
                                    case 'P': ++$dp; break;
                                    case 'N': ++$dn; break;
                                    case 'D': ++$dd; break;
                                    case 'R': ++$dr; break;
                                }
                                break;
                            case 'R': 
                                switch ($registro['ava_resposta']) {
                                    case 'P': ++$rp; break;
                                    case 'N': ++$rn; break;
                                    case 'D': ++$rd; break;
                                    case 'R': ++$rr; break;
                                }
                                break;
                        }
                        $resposta = 'A';
                    }
                    $jurado1 = !$jurado1;
                }

                $concordam = $pp + $nn + $dd + $rr;
                $n0 = $pp + $pn + $pd + $pr;
                $n1 = $np + $nn + $nd + $nr;
                $n2 = $dp + $dn + $dd + $dr;
                $n3 = $rp + $rn + $rd + $rr;

                $m0 = $pp + $np + $dp + $rp;
                $m1 = $pn + $nn + $dn + $rn;
                $m2 = $pd + $nd + $dd + $rd;
                $m3 = $pr + $nr + $dr + $rr;

                $po = $concordam / $total;
                $pe = (($m0/$total) * ($n0/$total) + 
                       ($m1/$total) * ($n1/$total) + 
                       ($m2/$total) * ($n2/$total) + 
                       ($m3/$total) * ($n3/$total));
                $k = ($po - $pe) / (1 - $pe);

                echo json_encode(array("grupo" => $i,
                           "concordam" => $concordam,
                           "reviews" => $total,
                           "po" => $po,
                           "pe" => $pe,
                           "k" => $k ));
            }
        }
}	
?>