<?php
namespace Myspace\BookmarkBundle\Controller;

class UsersController
{
    public function optionsUsersAction()
    {} // "options_users" [OPTIONS] /users

    public function getUsersAction()
    {} // "get_users"     [GET] /users

    public function newUsersAction()
    {} // "new_users"     [GET] /users/new

    public function postUsersAction()
    {} // "post_users"    [POST] /users

    public function patchUsersAction()
    {} // "patch_users"   [PATCH] /users

    public function getUserAction($slug)
    {} // "get_user"      [GET] /users/{slug}

    public function editUserAction($slug)
    {} // "edit_user"     [GET] /users/{slug}/edit

    public function putUserAction($slug)
    {} // "put_user"      [PUT] /users/{slug}

    public function patchUserAction($slug)
    {} // "patch_user"    [PATCH] /users/{slug}

    public function lockUserAction($slug)
    {} // "lock_user"     [PATCH] /users/{slug}/lock

    public function banUserAction($slug)
    {} // "ban_user"      [PATCH] /users/{slug}/ban

    public function removeUserAction($slug)
    {} // "remove_user"   [GET] /users/{slug}/remove

    public function deleteUserAction($slug)
    {} // "delete_user"   [DELETE] /users/{slug}

    public function getUserCommentsAction($slug)
    {} // "get_user_comments"    [GET] /users/{slug}/comments

    public function newUserCommentsAction($slug)
    {} // "new_user_comments"    [GET] /users/{slug}/comments/new

    public function postUserCommentsAction($slug)
    {} // "post_user_comments"   [POST] /users/{slug}/comments

    public function getUserCommentAction($slug, $id)
    {} // "get_user_comment"     [GET] /users/{slug}/comments/{id}

    public function editUserCommentAction($slug, $id)
    {} // "edit_user_comment"    [GET] /users/{slug}/comments/{id}/edit

    public function putUserCommentAction($slug, $id)
    {} // "put_user_comment"     [PUT] /users/{slug}/comments/{id}

    public function postUserCommentVoteAction($slug, $id)
    {} // "post_user_comment_vote" [POST] /users/{slug}/comments/{id}/vote

    public function removeUserCommentAction($slug, $id)
    {} // "remove_user_comment"  [GET] /users/{slug}/comments/{id}/remove

    public function deleteUserCommentAction($slug, $id)
    {} // "delete_user_comment"  [DELETE] /users/{slug}/comments/{id}

    public function linkUserAction($slug)
    {} // "link_user_friend"     [LINK] /users/{slug}

    public function unlinkUserAction($slug)
    {} // "unlink_user_friend"     [UNLINK] /users/{slug}
}