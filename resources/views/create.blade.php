<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>New User</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
                   <form method="post" action="{{route('saveuser')}}" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="username"> UserName</label>
                        <input class="form-control" id="username" name="username" placeholder="Enter username">
                    </div>
                     
                    <div class="form-group">
                        <label for="first_name"> First name</label>
                        <input class="form-control" id="first_name" name="first_name" placeholder="Enter first name">
                    </div>
                     
                    <div class="form-group">
                        <label for="last_name">Last name</label>
                    <input class="form-control" name="last_name" id="last_name" placeholder="Enter last name">
                    </div>
                     
                    <div class="form-group">
                        <label for="email">Email </label>
                        <input class="form-control" id="email" name="email" placeholder="Enter email">
                    </div>
                     
                    <div class="form-group">
                        <label for="password1">Password</label>
                        <input class="form-control" type="password" id="password1" name="password" placeholder="Enter password">
                    </div>
                     

                        <button type="submit" class="btn btn-primary">Save</button>
                   </form>

                   {{-- <form method="post" action="{{route('saveuser')}}">
                    @csrf

                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1"  placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </form> --}}
        </div>
    </body>
</html>
