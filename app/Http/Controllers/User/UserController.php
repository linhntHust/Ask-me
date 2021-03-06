<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedBackRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Models\FeedBack;
use App\Models\PollVoteHistory;
use App\Models\Tag;
use Auth;
use App\Models\Question;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $modelQuestion;
    protected $modelBlog;
    protected $modelCategory;
    protected $modelTag;
    public function __construct(
        Question $question,
        Blog $blog,
        Category $category,
        Tag $tag
    ){
        $this->modelBlog = $blog;
        $this->modelQuestion = $question;
        $this->modelCategory = $category;
        $this->modelTag = $tag;
    }

    public function userQuestion()
    {
        $user = Auth::user();
        $userQuestions = $this->modelQuestion->getUserQuestion($user->id);
        return view('user.question.user_question', compact('user', 'userQuestions'));
    }

    public function questionDetail($id)
    {
        $user = Auth::user();
        $questionDetail = $this->modelQuestion->getQuestionDetail($id);
        $relatedQuestions = $this->modelQuestion->getRelatedQuestion($id);
        if ($questionDetail->question_poll == 0) {
            return view('user.question.question_detail', compact('questionDetail', 'user','relatedQuestions'));
        } else{
            $userVote = PollVoteHistory::where('user_id', $user->id)->Where('question_id', $questionDetail->id)->first();
            if ($userVote != null){
                $voted = 1;
                return view('user.question.question_poll_detail', compact('questionDetail', 'user', 'voted','relatedQuestions'));
            } else {
                $voted = 0;
                return view('user.question.question_poll_detail', compact('questionDetail', 'user', 'voted','relatedQuestions'));
            }
        }
    }

    public function blogDetail($id)
    {
        $user = Auth::user();
        $blogDetail =  $this->modelBlog->getBlogDetail($id);
        return view('user.blog.blog_detail', compact('user','blogDetail'));
    }

    public function userHome()
    {
        $user = Auth::user();
        $recentQuestions = $this->modelQuestion->getRecentQuestions();
        $mostResponseQuestions = $this->modelQuestion->getMostResponseQuestions();
        $recentAnswerQuestions = $this->modelQuestion->getRecentAnswerQuestions();
        $noAnswerQuestions = $this->modelQuestion->getNoAnswerQuestion();
        return view('home', compact('recentQuestions', 'user', 'mostResponseQuestions', 'recentAnswerQuestions', 'noAnswerQuestions'));
    }

    public function userBlog()
    {
        $user = Auth::user();
        $userBlogs = $this->modelBlog->getUserBlog($user->id);
        return view('user.blog.user_blog', compact('user', 'userBlogs'));
    }

    public function closeQuestion($id)
    {
        $this->modelQuestion->closeQuestion($id);
        return redirect()->back();
    }

    public function reopenQuestion($id)
    {
        $this->modelQuestion->reopenQuestion($id);
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $input = $request->all();
        $questions = $this->modelQuestion->searchQuestion($input);
        $blogs = $this->modelBlog->searchBlog($input);
        $categories = $this->modelCategory->searchCategories($input);
        $tags = $this->modelTag->searchTags($input);
        $search = $request->get('search');
        return view('search_result',compact('questions','search','blogs', 'categories','tags'));
    }

    public function contract()
    {
        $user = Auth::user();
        return vieW('contract_us', compact('user'));
    }
    public function feedback(Request $request)
    {
        $input = $request->all();
        $feedback = FeedBack::create($input);

        return response()->json($feedback);
    }
}
