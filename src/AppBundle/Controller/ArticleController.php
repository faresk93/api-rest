<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Exception\ResourceValidationException;
use AppBundle\Form\ArticleType;
use AppBundle\Repository\ArticleRepository;
use AppBundle\Representation\Articles;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class ArticleController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     path="/articles/{id}",
     *     name="app_articles_show",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View()
     *
     * @param Article $article
     * @return Article|Response
     */
    public function showAction(Article $article = null)
    {
        if ($article) return $article;
        return new Response('Article Not Found!', Response::HTTP_NOT_FOUND);
    }

//    Post via Body_Converter

    /**
     * @Rest\Post(
     *     path="/articles",
     *     name="app_articles_post"
     * )
     *
     * @Rest\View(statusCode=201)
     * @ParamConverter(
     *     "article",
     *     converter="fos_rest.request_body",
     *     options={
     *          "validator"={"groups"="Create"}
     *     }
     * )
     *
     * @param Article $article
     * @param ConstraintViolationList $violations
     * @return \FOS\RestBundle\View\View
     * @throws ResourceValidationException
     */
    public function createAction(Article $article, ConstraintViolationList $violations)
    {
        if  (count($violations)) {

            $message = 'The JSON contains invalid data:';
            foreach ($violations as $violation) {
                $message.= sprintf(
                    "Field %s: %s ",
                    $violation->getPropertyPath(),
                    $violation->getMessage()

                );
            }
//            return $this->view($violations, Response::HTTP_BAD_REQUEST);
            throw new ResourceValidationException($message);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($article);
        $entityManager->flush();

        return $this->view(
            $article,
            Response::HTTP_CREATED,
            [
                'location' => $this->generateUrl('app_articles_show', ['id' => $article->getId()], UrlGeneratorInterface::ABSOLUTE_URL)
            ]
        );
    }

    /**
     * @Rest\Get(
     *     path="/articles",
     *     name="app_article_list"
     * )
     *
     * @Rest\QueryParam(
     *     name="keyword",
     *     nullable=true,
     *     description="The keyword to search for."
     * )
     *
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="5",
     *     description="Max number of articles per page."
     * )
     *
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="0",
     *     description="The pagination offset"
     * )
     *
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     description="Sort order (asc or desc)",
     *     default="asc",
     * )
     *
     * @Rest\View()
     *
     * @param $keyword
     * @param $order
     * @param $limit
     * @param $offset
     * @return Articles
     */
    public function listAction($keyword, $order, $limit, $offset)
    {
//        dump($keyword, $order, $limit, $offset);die;
        $pager = $this->getDoctrine()->getRepository('AppBundle:Article')->search($keyword, $order, $limit, $offset);
        $articlesRepository = $this->getDoctrine()->getRepository('AppBundle:Article');
        $articles = $articlesRepository->findBy([], ['id' => $order]);
//
        return $articles;

//        return $pager->getCurrentPageResults();
//        return new Articles($pager);
    }

    /**
     * @Rest\Delete(
     *     path="/articles/{id}",
     *     name="app_article_delete",
     *     requirements={"id":"\d+"}
     * )
     * @param Article $article
     * @return Response
     */
    public function deleteAction(Article $article)
    {
//        if (is_null($article)){
//            return new Response('Article not found!', Response::HTTP_NOT_FOUND);
//        }

//        $entityManager = $this->getDoctrine()->getManager();
//        $entityManager->remove($article);
//        $entityManager->flush();

        return new Response('aaa', 200);
    }
}
