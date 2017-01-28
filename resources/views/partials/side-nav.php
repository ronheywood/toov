

<p class="clearfix"/><p/><p/>
<ul class="nav" ng-hide="requireLogin">
  <li><a href="/">Blueprints</a></li>
  <li><a href="/logout">Logout</a></li>        
</ul>

<div id="loginModal" ng-class="requireLogin ? 'modal show' : 'ng-hide'" role="dialog" style="display: auto;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Login with your Eve Account</h4>
      </div>
      <div class="modal-body">
        <img src="https://images.contentful.com/idjq7aai9ylm/4fSjj56uD6CYwYyus4KmES/4f6385c91e6de56274d99496e6adebab/EVE_SSO_Login_Buttons_Large_Black.png?w=270&h=45" alt="Sign In" class="btn" ng-click="authenticate()"/>
      </div>
    </div>

  </div>
</div>