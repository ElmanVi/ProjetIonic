@extends('layouts.base')

    @section('content')
        <h1>The best Url Shorter out there!!!!!!</h1>

       <form method="POST">
           {{csrf_field()}}
           <input type="text" name="url" placeholder="Entrez votre url"
           value = {{old('url')}}>
           {!!$errors->first('url', '<p>:message</p>')!!}
           <input type="submit" value="envoyer">
       </form>
    @endsection
