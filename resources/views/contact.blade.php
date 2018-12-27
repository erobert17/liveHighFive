{{--@include('layouts.headerSecondary')--}}
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>
    {{--@include('layouts.navSecondary')--}}

    <!-- Header Image, Short and Wide -->
    <div class="container-full">
        <div class="row noMargins">
            <div id="shortWideHeader">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <h1 id="subHeaderTitleMargin">Agents</h1>
                </div>
                <div class="col-lg-1"></div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <h3>Contact Us</h3>
                <form action="contact" method="POST" class="vert-offset-bottom-2">
                    
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Subject</label>
                        <input type="text" class="form-control" name="subject" placeholder="Requesting more info, ">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Receipt</label><br>
                        <div class="smallMarginRight vert-offset-bottom-1">
                            <select id="receipt" name="receipt" class="selectpicker smallSelect2 selectpickerFirst dropup" dropupauto="true" data-size="4" tabindex="-98" style="width: 208px;">
                                <option value="General" selected="selected">General</option>
                                <option value="Tom Wiltse">Tom Wiltse</option>
                                <option value="Lisa Worsley-Matthews">Lisa Worsley-Matthews</option>
                                <option value="Conrad Reiter">Conrad Reiter</option>
                            </select><br>
                            <small id="emailHelp" class="form-text text-muted">If this message is for a specific person please specify.</small>
                        </div>
                    </div>

                    <div class="form-group vert-offset-top-6">
                        <label for="exampleInputEmail1">Message</label>
                        <textarea class="form-control" rows="10" name="message" placeholder="Message"> </textarea>
                    </div>

                    <button type="submit" class="btn btn-default">Submit</button>         

                </form>
            </div>
        </div>
    </div><!-- /.container -->

    <!-- Footer -->
    {{--@include('layouts.footer')--}}


</body>

</html>