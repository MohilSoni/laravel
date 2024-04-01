<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel CRUD using ajax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"/>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="p-4">Hello {{ Auth::user()->firstname }} <a href="{{ route('user.logout') }}"
                                                                           class="btn float-end me-3"
                                                                           style="border: none; font-size:18px;"
                                                                           title="Logout"><i
                                class="bi bi-box-arrow-in-right me-1"></i>Logout</a></h3>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="p-3">{{ Auth::user()->firstname }}</h5>
                        </div>
                        <div class="col-md-12 d-flex justify-content-center">
                            <p class="p-3" style="font-weight: 400"> Lorem Ipsum is simply dummy text of the printing
                                and typesetting industry. Lorem Ipsum has been the industry's
                                standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                                and scrambled it to make a
                                type specimen book. It has survived not only five centuries, but also the leap into
                                electronic typesetting,
                                remaining essentially unchanged. It was popularised in the 1960s with the release of
                                Letraset sheets containing
                                Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                                PageMaker including versions of
                                Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                Lorem Ipsum has been the industry's
                                standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                                and scrambled it to make a
                                type specimen book. It has survived not only five centuries, but also the leap into
                                electronic typesetting,
                                remaining essentially unchanged. It was popularised in the 1960s with the release of
                                Letraset sheets containing
                                Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                                PageMaker including versions of
                                Lorem Ipsum </p>
                        </div>
                        <div class="col-md-12">
                            <h6 class="p-3">Thank you</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>





