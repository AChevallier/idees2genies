<?php

namespace ApiBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\Config\Definition\Exception\Exception;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use ApiBundle\Entity\User;
    use ApiBundle\Entity\Idea;
    use ApiBundle\Entity\VoteUserIdea;
    use ApiBundle\Entity\Community;
    use ApiBundle\Entity\Comment;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;


class IdeaController extends Controller
{

    // Fonction qui liste toutes les idées
    public function indexAction(Request $request)
    {
        try{
            $token = $request->headers->get('token');

            $em = $this->getDoctrine()->getEntityManager();
            $repository = $em->getRepository('ApiBundle:User');

            $user = $repository->findOneBy(array('token' => $token));

            if($user){
                $valideToken = $user->getValideToken();
                $idUser = $user->getId();
                $date = new \DateTime();

                if($valideToken > $date){

                    $em = $this->getDoctrine()->getEntityManager();

                    $repository = $em->getRepository('ApiBundle:Idea');
                    $ideas = $repository->findBy(array(), array('publicateDate' => 'DESC'));

                    $tableIdeas = array();

                    foreach ($ideas as $idea) {

                        $idCommunityIdea = "";
                        $nameCommunityIdea = "";

                        if($idea->getIdCommunauty() != ""){
                            $repository = $em->getRepository('ApiBundle:Community');
                            $community = $repository->findOneBy(array('id' => $idea->getIdCommunauty()));

                            if($community){
                                $idCommunityIdea = $community->getId();
                                $nameCommunityIdea = $community->getName();
                            }
                        }

                        $repository = $this->getDoctrine()->getRepository('ApiBundle:VoteUserIdea');
                        $voteUser = $repository->findOneBy(array('idUser' => $idUser, 'idIdea' => $idea->getId()));

                        if($voteUser){
                            $voteUser = true;
                        }else{
                            $voteUser = false;
                        }

                        $repository = $this->getDoctrine()->getRepository('ApiBundle:User');
                        $auteur = $repository->findOneBy(array('id' => $idea->getIdUser()));

                        $qb = $em->createQueryBuilder()
                            ->select('COUNT(vui.id)')
                            ->from('ApiBundle:VoteUserIdea', 'vui')
                            ->where('vui.idIdea = :idIdea')
                            ->setParameters(array('idIdea' => $idea->getId()))
                        ;
                        $nbVotes = $qb->getQuery()->getSingleScalarResult();

                        $dateCreate = $idea->getPublicateDate();
                        $date = $dateCreate->format('d/m/Y à  H:i');

                        $qb = $em->createQueryBuilder()
                            ->select('c.id AS idComment ,c.comment AS commentComment, u.name AS nameAuthorComment, u.firstName AS firstNameAuthorComment, c.publicateDate AS publicateDate')
                            ->from('ApiBundle:Comment', 'c')
                            ->innerJoin('ApiBundle:User', 'u', 'WITH', 'u.id = c.idUser')
                            ->where('c.idIdea = :idIdea')
                            ->setParameters(array('idIdea' => $idea->getId()));
                            ;

                        $comments = null;
                        $comments = $qb->getQuery()->getResult();

                        $tableComments = array();

                        if($comments){
                            foreach ($comments as $comment) {

                                $qb = $em->createQueryBuilder()
                                    ->select('COUNT(vuc.id)')
                                    ->from('ApiBundle:VoteUserComment', 'vuc')
                                    ->where('vuc.idComment = :idComment')
                                    ->setParameters(array('idComment' => $comment['idComment']));
                                $nbCommentsVotes = $qb->getQuery()->getSingleScalarResult();

                                $repository = $this->getDoctrine()->getRepository('ApiBundle:VoteUserComment');
                                $voteUserComment = $repository->findOneBy(array('idUser' => $idUser, 'idComment' => $comment['idComment']));

                                if($voteUserComment){
                                    $voteUserComment = true;
                                }else{
                                    $voteUserComment = false;
                                }

                                $dateCreate = $comment['publicateDate'];
                                $date = $dateCreate->format('d/m/Y à  H:i');

                                $tableComments[] = array(
                                    'id' => $comment['idComment'],
                                    'comment' => $comment['commentComment'],
                                    'authorName' => $comment['nameAuthorComment'],
                                    'authorFirstName' => $comment['firstNameAuthorComment'],
                                    'publicateDate' => $date,
                                    'nbCommentsVotes' => $nbCommentsVotes,
                                    'voteUserComment' => $voteUserComment,
                                );
                            }
                        }

                        $qb = $em->createQueryBuilder()
                            ->select('COUNT(c.id)')
                            ->from('ApiBundle:Comment', 'c')
                            ->where('c.idIdea = :idIdea')
                            ->setParameters(array('idIdea' => $idea->getId()))
                        ;
                        $nbComments = $qb->getQuery()->getSingleScalarResult();

                        $repository = $this->getDoctrine()->getRepository('ApiBundle:UserCommunity');
                        $userCanComment = $repository->findOneBy(array('idUser' => $idUser, 'idCommunity' => $idea->getIdCommunauty()));

                        if($userCanComment || ($idea->getIdCommunauty() == "")){
                            $userCanComment = true;
                        }else{
                            $userCanComment = false;
                        }
                            $tableIdeas[] = array(
                            'id' => $idea->getId(),
                            'title' => $idea->getTitle(),
                            'idea' => $idea->getIdea(),
                            'auteur' => $auteur->getFirstName().' '.$auteur->getName(),
                            'date' => $date,
                            'voteUser' => $voteUser,
                            'nbVotes' => $nbVotes,
                            'comments' => $tableComments,
                            'nbComments' => $nbComments,
                            'userCanComment' => $userCanComment,
                            'idCommunityIdea' => $idCommunityIdea,
                            'nameCommunityIdea' => $nameCommunityIdea,
                        );
                    }
                    return $this->get('service_data_response')->JsonResponse($tableIdeas);

                }else{
                    return $this->get('service_errors_messages')->errorMessage("005");
                }
            }else{
                return $this->get('service_errors_messages')->errorMessage("004");
            }
        }catch(Exception $ex) {
            return $this->get('service_errors_messages')->errorMessage("001");
        }
    }

    // Fonction qui liste les idées d'une communauté
    public function ideasCommunityAction(Request $request)
    {
        try{
            $token = $request->headers->get('token');

            $em = $this->getDoctrine()->getEntityManager();
            $repository = $em->getRepository('ApiBundle:User');

            $user = $repository->findOneBy(array('token' => $token));

            if($user){
                $valideToken = $user->getValideToken();
                $idUser = $user->getId();
                $date = new \DateTime();

                if($valideToken > $date){

                    $data = json_decode($request->getContent(), true);

                    if(!empty($data['id']) && isset($data['id'])) {

                        $repository = $em->getRepository('ApiBundle:Community');

                        if($community = $repository->findOneBy(array('id' => $data['id']))) {

                            $em = $this->getDoctrine()->getEntityManager();

                            $repository = $em->getRepository('ApiBundle:Idea');
                            $ideas = $repository->findBy(array('idCommunauty' => $data['id']), array('publicateDate' => 'DESC'));

                            $tableIdeas = array();

                            foreach ($ideas as $idea) {

                                $repository = $this->getDoctrine()->getRepository('ApiBundle:VoteUserIdea');
                                $voteUser = $repository->findOneBy(array('idUser' => $idUser, 'idIdea' => $idea->getId()));

                                if ($voteUser) {
                                    $voteUser = true;
                                } else {
                                    $voteUser = false;
                                }

                                $repository = $this->getDoctrine()->getRepository('ApiBundle:User');
                                $auteur = $repository->findOneBy(array('id' => $idea->getIdUser()));

                                $qb = $em->createQueryBuilder()
                                    ->select('COUNT(vui.id)')
                                    ->from('ApiBundle:VoteUserIdea', 'vui')
                                    ->where('vui.idIdea = :idIdea')
                                    ->setParameters(array('idIdea' => $idea->getId()));
                                $nbVotes = $qb->getQuery()->getSingleScalarResult();


                                $dateCreate = $idea->getPublicateDate();
                                $date = $dateCreate->format('d/m/Y à  H:i');

                                $qb = $em->createQueryBuilder()
                                    ->select('c.id AS idComment ,c.comment AS commentComment, u.name AS nameAuthorComment, u.firstName AS firstNameAuthorComment, c.publicateDate AS publicateDate')
                                    ->from('ApiBundle:Comment', 'c')
                                    ->innerJoin('ApiBundle:User', 'u', 'WITH', 'u.id = c.idUser')
                                    ->where('c.idIdea = :idIdea')
                                    ->setParameters(array('idIdea' => $idea->getId()));
                                ;

                                $comments = null;
                                $comments = $qb->getQuery()->getResult();

                                $tableComments = array();

                                if($comments){
                                    foreach ($comments as $comment) {

                                        $qb = $em->createQueryBuilder()
                                            ->select('COUNT(vuc.id)')
                                            ->from('ApiBundle:VoteUserComment', 'vuc')
                                            ->where('vuc.idComment = :idComment')
                                            ->setParameters(array('idComment' => $comment['idComment']));
                                        $nbCommentsVotes = $qb->getQuery()->getSingleScalarResult();

                                        $repository = $this->getDoctrine()->getRepository('ApiBundle:VoteUserComment');
                                        $voteUserComment = $repository->findOneBy(array('idUser' => $idUser, 'idComment' => $comment['idComment']));

                                        if($voteUserComment){
                                            $voteUserComment = true;
                                        }else{
                                            $voteUserComment = false;
                                        }

                                        $dateCreate = $comment['publicateDate'];
                                        $date = $dateCreate->format('d/m/Y à  H:i');

                                        $tableComments[] = array(
                                            'id' => $comment['idComment'],
                                            'comment' => $comment['commentComment'],
                                            'authorName' => $comment['nameAuthorComment'],
                                            'authorFirstName' => $comment['firstNameAuthorComment'],
                                            'publicateDate' => $date,
                                            'nbCommentsVotes' => $nbCommentsVotes,
                                            'voteUserComment' => $voteUserComment,
                                        );
                                    }
                                }

                                $qb = $em->createQueryBuilder()
                                    ->select('COUNT(c.id)')
                                    ->from('ApiBundle:Comment', 'c')
                                    ->where('c.idIdea = :idIdea')
                                    ->setParameters(array('idIdea' => $idea->getId()))
                                ;
                                $nbComments = $qb->getQuery()->getSingleScalarResult();

                                $userCanComment = null;

                                $repository = $this->getDoctrine()->getRepository('ApiBundle:UserCommunity');
                                $userCanComment = $repository->findOneBy(array('idUser' => $idUser, 'idCommunity' => $idea->getIdCommunauty()));

                                if($userCanComment || ($idea->getIdCommunauty() == "NULL")){
                                    $userCanComment = true;
                                }else{
                                    $userCanComment = false;
                                }

                                $tableIdeas[] = array(
                                    'id' => $idea->getId(),
                                    'title' => $idea->getTitle(),
                                    'idea' => $idea->getIdea(),
                                    'auteur' => $auteur->getFirstName() . ' ' . $auteur->getName(),
                                    'date' => $date,
                                    'voteUser' => $voteUser,
                                    'nbVotes' => $nbVotes,
                                    'comments' => $tableComments,
                                    'nbComments' => $nbComments,
                                    'userCanComment' => $userCanComment,
                                );
                            }
                            return $this->get('service_data_response')->JsonResponse($tableIdeas);
                        }else{
                            return $this->get('service_errors_messages')->errorMessage("010");
                        }
                    }else{
                        return $this->get('service_errors_messages')->errorMessage("002");
                    }

                }else{
                    return $this->get('service_errors_messages')->errorMessage("005");
                }
            }else{
                return $this->get('service_errors_messages')->errorMessage("004");
            }
        }catch(Exception $ex) {
            return $this->get('service_errors_messages')->errorMessage("001");
        }
    }

    // Fonction qui liste le top 5
    public function top5Action(Request $request)
    {
        try{
            $token = $request->headers->get('token');

            $em = $this->getDoctrine()->getEntityManager();
            $repository = $em->getRepository('ApiBundle:User');

            $user = $repository->findOneBy(array('token' => $token));

            if($user){
                $valideToken = $user->getValideToken();
                $idUser = $user->getId();
                $date = new \DateTime();

                if($valideToken > $date){

                    $em = $this->getDoctrine()->getEntityManager();

                    $qb = $em->createQueryBuilder()
                        ->select('vui.idIdea AS idIdea, i.title AS title,u.name AS nameAutor, u.firstName AS firstNameAutor, i.publicateDate AS publicateDate, count(vui.id) AS nbVote')
                        ->from('ApiBundle:VoteUserIdea', 'vui')
                        ->innerJoin('ApiBundle:Idea', 'i', 'WITH', 'i.id = vui.idIdea')
                        ->innerJoin('ApiBundle:User', 'u', 'WITH', 'i.idUser = u.id')
                        ->groupBy('vui.idIdea')
                        ->addOrderBy('nbVote', 'DESC')
                        ->addOrderBy('i.publicateDate', 'DESC')
                        ->setMaxResults(5);

                    $ideas = $qb->getQuery()->getResult();

                    $tableIdeas = array();
                    foreach ($ideas as $idea) {

                       $dateCreate = $idea['publicateDate'];
                        $date = $dateCreate->format('d/m/Y');
                        $heure = $dateCreate->format('H:i');

                        $tableIdeas[] = array(
                            'idIdea' => $idea['idIdea'],
                            'title' => $idea['title'],
                            'nameAutor' => $idea['nameAutor'],
                            'firstNameAutor' => $idea['firstNameAutor'],
                            'publicateDate' => $date,
                            'publicateHour' => $heure,
                            'nbVote' => $idea['nbVote'],
                        );
                    }
                    return $this->get('service_data_response')->JsonResponse($tableIdeas);
                }else{
                    return $this->get('service_errors_messages')->errorMessage("005");
                }
            }else{
                return $this->get('service_errors_messages')->errorMessage("004");
            }
        }catch(Exception $ex) {
            return $this->get('service_errors_messages')->errorMessage("001");
        }
    }

    // Fonction qui ajoute une idée
    public function addAction(Request $request)
    {
        try{
            $token = $request->headers->get('token');

            $em = $this->getDoctrine()->getEntityManager();
            $repository = $em->getRepository('ApiBundle:User');

            $user = $repository->findOneBy(array('token' => $token));

            if($user){
                $valideToken = $user->getValideToken();
                $date = new \DateTime();

                if($valideToken > $date){

                    $data = json_decode($request->getContent(), true);

                    if (!empty(isset($data['title'])) && !empty(isset($data['idea']))){

                        try{
                            $idea = new Idea();
                            $idea->setTitle($data['title']);
                            $idea->setIdea($data['idea']);
                            $idea->setIdUser($user->getId());
                            $idea->setPublicateDate($date = new \DateTime());

                            if(isset($data['idCommunity'])){
                                if($data['idCommunity'] != ''){
                                    $repository = $em->getRepository('ApiBundle:Community');
                                    $community = $repository->findOneBy(array('id' => $data['idCommunity']));

                                    if($community){
                                        $idea->setIdCommunauty($data['idCommunity']);
                                    }else{
                                        return $this->get('service_errors_messages')->errorMessage("010");
                                    }
                                }
                            }

                            $em->persist($idea);
                            $em->flush();

                            $date = new \DateTime();
                            $date = $date->format('Y-m-d H:i:s');

                            $data = array(
                                'title' => $data['title'],
                                'idea' => $data['idea'],
                                'date' => $date,
                            );

                            return $this->get('service_data_response')->JsonResponse($data);

                        }catch(Exception $ex){
                            return $this->get('service_errors_messages')->errorMessage("001");
                        }
                    }else{
                        return $this->get('service_errors_messages')->errorMessage("002");
                    }
                }else{
                    return $this->get('service_errors_messages')->errorMessage("005");
                }
            }else{
                return $this->get('service_errors_messages')->errorMessage("004");
            }
        }catch(Exception $ex) {
            return $this->get('service_errors_messages')->errorMessage("001");
        }
    }

    // Fontion qui permet de voter
    public function voteAction(Request $request)
    {
        try{
            $token = $request->headers->get('token');

            $em = $this->getDoctrine()->getEntityManager();
            $repository = $em->getRepository('ApiBundle:User');

            $user = $repository->findOneBy(array('token' => $token));

            if($user){
                $valideToken = $user->getValideToken();
                $date = new \DateTime();

                if($valideToken > $date){

                    $data = json_decode($request->getContent(), true);

                    $repository = $em->getRepository('ApiBundle:Idea');

                    if(isset($data['id'])){
                        if($idea = $repository->findOneBy(array('id' => $data['id']))) {

                            $repository = $em->getRepository('ApiBundle:VoteUserIdea');

                            if($voteUserIdea = $repository->findOneBy(array('idUser' => $user->getId(), 'idIdea' => $data['id']))){

                                $em->remove($voteUserIdea);
                                $em->flush();

                                $data = array(
                                    'vote' => false,
                                );

                                return $this->get('service_data_response')->JsonResponse($data);
                            }else{

                                $voteUserIdea = new VoteUserIdea();

                                $voteUserIdea->setIdIdea($data['id']);
                                $voteUserIdea->setIdUser($user->getId());

                                $em->persist($voteUserIdea);
                                $em->flush();

                                $data = array(
                                    'vote' => true,
                                );

                                return $this->get('service_data_response')->JsonResponse($data);
                            }

                        }else{
                            return $this->get('service_errors_messages')->errorMessage("011");
                        }
                    }
                    else{
                        return $this->get('service_errors_messages')->errorMessage("002");
                    }
                }else{
                    return $this->get('service_errors_messages')->errorMessage("005");
                }
            }else{
                return $this->get('service_errors_messages')->errorMessage("004");
            }
        }catch(Exception $ex) {
            return $this->get('service_errors_messages')->errorMessage("001");
        }
    }
}

