<?php

namespace App\Controller;

use Sifoni\Controller\Base;
use App\Model\Article;
use App\Model\Comment;
use App\Model\Category;
use App\Model\Articles_Tags;
use App\Model\Tags;

class HomeController extends Base {
    public function indexAction() {
    	$data = array();

        $data['articles'] = Article::orderBy('id', 'desc')->get();
        foreach ($data['articles'] as $article) {
        	$data['number_comment'][$article['id']] = count(Comment::where('article_id', '=', $article['id'])->get());
        }

        $data['four_articles'] = Article::orderBy('id','desc')->limit(5)->get();
    	$data['four_category'] = Category::orderBy('id','desc')->limit(5)->get();

        return $this->render('home/index.html.twig', $data);
    }

    public function showArticleAction($article_id)
    {
        $data = array();

    	$data['article'] = Article::where('id', '=', $article_id)->get()[0];

        $data['tags_id'] = Articles_Tags::where('article_id', '=', $article_id)->get(['tag_id']);
        foreach ($data['tags_id'] as $idtag) {
            $data['tags_name'][] = Tags::where('id', '=', $idtag['tag_id'])->get()[0];
        }

        $data['comments'] = Comment::where('article_id', '=', $article_id)->get();

        $data['four_articles'] = Article::orderBy('id','desc')->limit(5)->get();
        $data['four_category'] = Category::orderBy('id','desc')->limit(5)->get();

        return $this->render('article/showArticle.html.twig', $data);
    }

    public function showCategoryAction($category_id)
    {
        $data = array();

        $data['articles'] = Article::orderBy('id', 'desc')->get();
        foreach ($data['articles'] as $article) {
            $data['number_comment'][$article['id']] = count(Comment::where('article_id', '=', $article['id'])->get());
        }

        $data['articles'] = Article::where('category_id', '=', $category_id)->get();

        $data['four_articles'] = Article::orderBy('id','desc')->limit(5)->get();
        $data['four_category'] = Category::orderBy('id','desc')->limit(5)->get();

        return $this->render('category/showCategory.html.twig', $data);
    }
}
