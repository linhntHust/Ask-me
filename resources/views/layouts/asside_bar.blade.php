<aside class="col-md-3 sidebar">
        <div class="widget widget_stats">
            <h3 class="widget_title">Stats</h3>
            <div class="ul_list ul_list-icon-ok">
                <ul>
                    <li><i class="icon-question-sign"></i>Questions ( <span>20</span> )</li>
                    <li><i class="icon-comment"></i>Answers ( <span>50</span> )</li>
                </ul>
            </div>
        </div>
        
        <div class="widget widget_social">
            <h3 class="widget_title">Find Us</h3>
            <ul>
                <li class="rss-subscribers">
                    <a href="#" target="_blank">
                    <strong>
                        <i class="icon-rss"></i>
                        <span>Subscribe</span><br>
                        <small>To RSS Feed</small>
                    </strong>
                    </a>
                </li>
                <li class="facebook-fans">
                    <a href="#" target="_blank">
                    <strong>
                        <i class="social_icon-facebook"></i>
                        <span>5,000</span><br>
                        <small>People like it</small>
                    </strong>
                    </a>
                </li>
                <li class="twitter-followers">
                    <a href="#" target="_blank">
                    <strong>
                        <i class="social_icon-twitter"></i>
                        <span>3,000</span><br>
                        <small>Followers</small>
                    </strong>
                    </a>
                </li>
                <li class="youtube-subs">
                    <a href="#" target="_blank">
                    <strong>
                        <i class="icon-play"></i>
                        <span>1,000</span><br>
                        <small>Subscribers</small>
                    </strong>
                    </a>
                </li>
            </ul>
        </div>
        
        @guest
        <div class="widget widget_login">
            <h3 class="widget_title">Login</h3>
            <div class="form-style form-style-2">
                <form method="POST" role="form" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="form-inputs clearfix">
                        <p class="login-text">
                            <input type="text" value="Username" name="name" onfocus="if (this.value == 'Username') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Username';}">
                            <i class="icon-user"></i>
                        </p>
                        <p class="login-password">
                            <input type="password" value="Password" name="password" onfocus="if (this.value == 'Password') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Password';}">
                            <i class="icon-lock"></i>
                            <a href="#">Forget</a>
                        </p>
                    </div>
                    <p class="form-submit login-submit">
                        <input type="submit" value="Log in" class="button color small login-submit submit">
                    </p>
                    <div class="rememberme">
                        <label><input type="checkbox" checked="checked"> Remember Me</label>
                    </div>
                </form>
                <ul class="login-links login-links-r">
                    <li><a href="#">Register</a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
        @endguest
        
        <div class="widget widget_highest_points">
            <h3 class="widget_title">Highest points</h3>
            <ul>
                <li>
                    <div class="author-img">
                        <a href="#"><img width="60" height="60" src="http://placehold.it/60x60/FFF/444" alt=""></a>
                    </div> 
                    <h6><a href="#">admin</a></h6>
                    <span class="comment">12 Points</span>
                </li>
                <li>
                    <div class="author-img">
                        <a href="#"><img width="60" height="60" src="http://placehold.it/60x60/FFF/444" alt=""></a>
                    </div> 
                    <h6><a href="#">vbegy</a></h6>
                    <span class="comment">10 Points</span>
                </li>
                <li>
                    <div class="author-img">
                        <a href="#"><img width="60" height="60" src="http://placehold.it/60x60/FFF/444" alt=""></a>
                    </div> 
                    <h6><a href="#">ahmed</a></h6>
                    <span class="comment">5 Points</span>
                </li>
            </ul>
        </div>
        
        <div class="widget widget_tag_cloud">
            <h3 class="widget_title">Tags</h3>
            <a href="#">projects</a>
            <a href="#">Portfolio</a>
            <a href="#">Wordpress</a>
            <a href="#">Html</a>
            <a href="#">Css</a>
            <a href="#">jQuery</a>
            <a href="#">2code</a>
            <a href="#">vbegy</a>
        </div>
        
        <div class="widget">
            <h3 class="widget_title">Recent Questions</h3>
            <ul class="related-posts">
                <li class="related-item">
                    <h3><a href="#">This is my first Question</a></h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <div class="clear"></div><span>Feb 22, 2014</span>
                </li>
                <li class="related-item">
                    <h3><a href="#">This Is My Second Poll Question</a></h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <div class="clear"></div><span>Feb 22, 2014</span>
                </li>
            </ul>
        </div>
        
    </aside><!-- End sidebar -->