<?php

namespace AppBundle\Controller;

use AppBundle\Library\Holder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Unirest;
class DefaultController extends Controller
{
	private $exerciceId;

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

	/**
	 * Permet de trier les cards
	 *
	 * @param Request $resquest : objet request
	 * @return Response : json contenant le trie de carte
	 * @Route("/sort-cards/", options={"expose"=true}, name="sort_cards")
	 */
	public function sortCards(Request $resquest)
	{
		Unirest\Request::verifyPeer(false);
		$responseWs = Unirest\Request::get($this->getParameter('url_ws_sort_card'), array('Accept' => 'application/json'));
		$this->exerciceId = $responseWs->body->exerciceId;

		$cardHolder = new Holder($responseWs->body->data->cards);
		$cardHolder->sortCards();

		$data = $this->get('jms_serializer')->serialize(array(
																'cards'         => $cardHolder->getCards(),
																'categoryOrder' => $cardHolder->getOrdredCategories(),
																'valueOrder' => $cardHolder->getOrdredValues(),
															),
															'json'
														);
		return new Response($data);
	}

	/**
	 * Permet de verifier le resultat des tris sur les cartes
	 *
	 * @param Request $resquest : objet request
	 * @return Response : json contenant le trie de carte
	 * @Route("/verify-sort-cards/", options={"expose"=true}, name="verify_sort_cards")
	 */
	public function verifySortCards(Request $resquest)
	{
		Unirest\Request::verifyPeer(false);
		$responseWs = Unirest\Request::post($this->getParameter('url_ws_sort_card_result') . $this->exerciceId, array('Accept' => 'application/octet-stream'));

		return new Response($this->get('jms_serializer')->serialize($responseWs, 'json'));
	}
}
