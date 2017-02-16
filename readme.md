# About Flamingoleaves

Flamingoleaves is a blogging platform site built upon the Laravel web application framework. The aim
of this application is to showcase frontend development along with an understanding of the backend.
Below is a list of anticipated features where items are crossed off as implemented.


## Recent changes

- Added the [Debugbar](https://github.com/barryvdh/laravel-debugbar) for Laravel. Needs a `composer update` and `composer install` possibly to get it working. (Randy)
- Added a `.env` file for my local machine. Should have no impact on anything else. (Randy)


## Todos

1. User Authentication
  1. Password Complexity Check
  1. ~~Forgot Password~~
1. Authorization / Access Control
    1. ~~Add/Edit/Delete Post~~
1. ~~Content creator 'Backend' including a dashboard and blog creation form~~
  1. ~~Basics~~
  1. ~~[Markdown input](https://github.com/erusev/parsedown)~~
1. Content viewing 'Frontend' with ability to add comments and tags
  1. ~~Pretty URLs using slugs~~
  1. ~~Tags~~
    1. ~~Update blog controller to display tags~~
  1. Comments
    1. ~~Install Disqus~~
    1. implement recommended blade template
    1. remove custom Comments solution
1. ~~Categories~~
    1. ~~update blog controller's category display~~
1. Images and Gallery
    1. ~~Update blog controller to display images~~
    1. ~~Update post controller to display, delete images~~
    1. Use the frontend and ajax as a means to delete images
    1. Move image storage location from public folder
        1. Implement means of transferring images from non-public storage
    1. Create a gallery based on user and grouped by post.
1. Add an RSS feed
1. Add a site map
1. ~~Email address verification before registration completion~~
1. Create a custom frontend without the use of a tool like Bootstrap
1. ~~Implement an repository pattern for code heavy controllers~~
    1. ~~Make use of interfaces for better code maintenance and scalability~~

## Non-Code Todos

1. Sign up for Digital Ocean
1. Sign up for Forge
1. ~~Sign up for Mailtrap~~
1. Wireframe new frontend
1. Read HeadFirst Design Patterns
1. ~~Register flamingoleaves.com domain~~
1. Update Laravel Homestead to latest version
    1. Replace Mailtrap with Mailhog
1. ~~Sign up for [Laracasts](https://laracasts.com/)~~
1. ~~Sign up for [Laracon ONLINE](https://laracon.net/)~~
