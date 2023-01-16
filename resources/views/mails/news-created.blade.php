<x-mail::message>
# Introduction

Hello {{ $user->name }},

This is to notify you that you have now successfully created a news. The news details are as follows:

<b> Title: </b> {{ $news->title }} </br> </br>

<b> Content: </b> {{ $news->content }} </br> 

<b> Created At: </b> {{ $news->created_at->diffForHumans() }} </br> 

Thank you,<br>

{{ config('app.name') }}
</x-mail::message>
