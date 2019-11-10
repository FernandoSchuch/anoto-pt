<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed - Conhecimentos');
  
    class Reviewmodel extends CI_Model {
        
        public function __construct() {
            parent::__construct();            
        }
        
        public function getReviewsFaltantes($email){
            $sql = "SELECT IFNULL(count(*), 0) as retorno
                      FROM avaliacoes_usuario
                     WHERE ava_email = '".$email."' AND
                           ava_resposta = 'A';";
            
            return $this->db->query($sql)->row_array()['retorno'];
        }
        
        public function getNextReview($email) {
            if($email) {
                /*$sql = "SELECT rev_id, 
                               rev_categoria,
                               REPLACE(rev_produto, rev_categoria, '') as rev_produto,
                               REPLACE(REPLACE(rev_opiniao, 'O que gostei:', '<br>O que gostei:'), 'O que não gostei:', '<br>O que não gostei:') as rev_opiniao,
                               RAND() as random
                        FROM   reviews a 
                               LEFT JOIN total_avaliacoes b USING(rev_id) 
                        WHERE  rev_id NOT IN (SELECT rev_id
                                              FROM   avaliacoes_usuario 
                                              WHERE  ava_email = '". $email ."') AND
                               COALESCE(b.tot_quantidade, 0) < 5
                        ORDER BY b.tot_quantidade DESC, random
                        LIMIT 1";*/
                $sql = "SELECT a.rev_id, 
                               rev_categoria,
                               REPLACE(rev_produto, rev_categoria, '') as rev_produto,
                               REPLACE(REPLACE(rev_opiniao, 'O que gostei:', '<br>O que gostei:'), 'O que não gostei:', '<br>O que não gostei:') as rev_opiniao
                        FROM   avaliacoes_usuario a
                               JOIN reviews b ON b.rev_id = a.rev_id
                        WHERE  a.ava_email = '".$email."' AND
                               a.ava_resposta = 'A';"; 
                $query  = $this->db->query($sql);
                $review = $query->row_array();
                return $review;
            } else {
                return false;
            }
        }
        
        public function setRepostaReview($email, $review, $resposta){
            if ($email != 'teste'){
                $avaliacao = array("ava_resposta" => $resposta);
                $this->db->update('avaliacoes_usuario', $avaliacao, array("rev_id"    => $review,
                                                                          "ava_email" => $email));          
            }
        }
        
        public function addVoluntario($email, $quant){
            $sqlRev = "select x.rev_id
                         from ( select rev_id as rev_id         
                                      ,RAND() as random
                                      ,tot_quantidade
                                  from reviews r
                                       join totais_produto t on t.rev_produto = r.rev_produto
                                 where r.rev_grupo is null) x
                        order by x.tot_quantidade desc, x.random 
                        limit ".$quant.";";
            /*$sqlRev = "SELECT x.rev_id
                         FROM (SELECT rev2.rev_id
                                     ,RAND() as random
                                 FROM reviews rev2
                                WHERE rev2.rev_grupo IS NULL
                                ORDER BY 2) x
                        LIMIT ".$quant.";";*/
            $reviews = $this->db->query($sqlRev)->result_array();
            
            $sqlGrupo = "SELECT IFNULL(MAX(rev_grupo), 0) + 1 as proximo_grupo
                           FROM reviews;";
            $grupo = $this->db->query($sqlGrupo)->row_array()['proximo_grupo'];
            
            foreach ($reviews as $review){
                $this->db->insert('avaliacoes_usuario', array("rev_id" => $review['rev_id'],
                                                              "ava_email" => $email,
                                                              "ava_resposta" => 'A'));
                $this->db->update('reviews', array("rev_grupo" => $grupo), array("rev_id" => $review['rev_id']));
            }
            return $grupo;
        }
        
        public function vinculaVoluntario($email, $grupo){
            $sqlRev = "SELECT rev_id
                         FROM reviews
                        WHERE rev_grupo = ".$grupo.";";
            $reviews = $this->db->query($sqlRev)->result_array();
            foreach ($reviews as $review){
                $this->db->insert('avaliacoes_usuario', array("rev_id" => $review['rev_id'],
                                                              "ava_email" => $email,
                                                              "ava_resposta" => 'A'));
            }
            return true;
        }
        
        public function getResultados($grupo){ 
            $sql = "SELECT ava.rev_id
                          ,ava.ava_resposta
                          ,ava.ava_email
                      FROM avaliacoes_usuario ava
                           JOIN reviews       rev on rev.rev_id = ava.rev_id 
                     WHERE rev.rev_grupo in (".$grupo.") and ava.ava_email <> 'terceiro'
                     ORDER BY ava.rev_id, ava.ava_email;";
            return $this->db->query($sql)->result_array();
        }
    }    
?>
