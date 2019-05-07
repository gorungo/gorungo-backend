<!--Footer-->
<footer class="page-footer font-small unique-color-dark pt-0 mt-4">

    <div style="background-color: #6351ce;">
        <div class="container">
            <!--Grid row-->
            <div class="row py-4 d-flex align-items-center">
                <!--Grid column-->
                <div class="col-md-6 col-lg-5">
                    <h5 class="text-white mb-0">{{__('texts.subscription_title')}}</h5>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-md-6 col-lg-7 text-center text-md-right">
                    <!--Facebook-->
                    <a href="#"><i class="fab fa-facebook text-white mr-lg-4"></i></a>
                    <!--Instagram-->
                    <a href="https://instagram.com/gorungo.ru"><i class="fab fa-instagram text-white mr-lg-4"></i></a>
                    <!--Vk-->
                    <a href="#"><i class="fab fa-vk text-white mr-lg-4"></i></a>
                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->
        </div>
    </div>

    <!--Footer Links-->
    <div class="container">
        <div class="row mt-4">

            <!--First column-->
            <div class="col-md-3 col-lg-4 col-xl-3">
                <h6 class="text-uppercase font-weight-bold">
                    <strong>{{__('general.name')}}</strong>
                </h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p>{{__('general.full_description')}}</p>
                @include('parts.locale_selector')
            </div>
            <!--/.First column-->

            <!--Second column-->
            <div class="col-md-2 col-lg-3 col-xl-2">
                <h6 class="text-uppercase font-weight-bold">
                    <strong>{{__('footer.sections')}}</strong>
                </h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p><a href="#!">{{__('idea.title')}}</a></p>
                <p><a href="#!">{{__('action.title')}}</a></p>
            </div>
            <!--/.Second column-->

            <!--Third column-->
            <div class="col-md-3 col-lg-3 col-xl-3 mb-4">
                <h6 class="text-uppercase font-weight-bold">
                    <strong>{{__('footer.resources')}}</strong>
                </h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p><a href="#!">{{__('footer.resources_policies')}}</a></p>
                <p><a href="#!">{{__('footer.resources_guidelines')}}</a></p>
                <p><a href="#!">{{__('footer.resources_help_center')}}</a></p>
                <p><a href="#!">{{__('footer.resources_privacy')}}</a></p>
            </div>
            <!--/.Third column-->

            <!--Fourth column-->
            <div class="col-md-4 col-lg-3 col-xl-4">
                <h6 class="text-uppercase font-weight-bold">
                    <strong>{{__('footer.contacts')}}</strong>
                </h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p><i class="fa fa-home mr-3"></i> New York, NY 10012, US</p>
                <p><i class="fa fa-envelope mr-3"></i> info@example.com</p>
                <p><i class="fa fa-phone mr-3"></i> + 01 234 567 88</p>
                <p><i class="fa fa-print mr-3"></i> + 01 234 567 89</p>
            </div>
            <!--/.Fourth column-->
        </div>
    </div>
    <!--/.Footer Links-->
    <!-- Copyright-->
    <div class="footer-copyright py-3 text-center">
        <div class="container-fluid">
            {{__('general.copyrights')}}</a>
        </div>
    </div>
    <!--/.Copyright -->

</footer>
<!--/.Footer-->