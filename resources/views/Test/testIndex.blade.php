@extends('layouts.app')

@section('content')
<div>
  <h1>Article Test Page</h1>
  <br/>
  <h2>Create Article</h2>
  <form id="createArticleForm" action="/createarticle" method="POST">
    {{ csrf_field() }}

    <table>
      <tr>
        <td>
          Name
        </td>
        <td>
          <input type="text" name="name" form="createArticleForm">
        </td>
      </tr>
      <tr>
        <td>
          Content
        </td>
        <td>
          <input type="text" name="content" form="createArticleForm">
        </td>
      </tr>
      <tr>
        <td>
          <input type="submit" value="submit">
        </td>
      </tr>
      </table>
  </form>
  <br/>
  <h2>Publish Article</h2>
  <form id="publishArticleForm" action="/publisharticle" method="POST">
    {{ csrf_field() }}

    <table>
      <tr>
        <td>
           Article ID
        </td>
        <td>
          <input type="number" name="articleID" form="publishArticleForm">
        </td>
      </tr>
      <tr>
        <td>
          <input type="submit" value="submit">
        </td>
      </tr>
      </table>
  </form>
  <br/>
  <h2>Submit Article For Review</h2>
  <form id="submitArticleForReviewForm" action="/submitarticleforreview" method="POST">
    {{ csrf_field() }}

    <table>
      <tr>
        <td>
           Article ID
        </td>
        <td>
          <input type="number" name="articleID" form="submitArticleForReviewForm">
        </td>
      </tr>
      <tr>
        <td>
          <input type="submit" value="submit">
        </td>
      </tr>
      </table>
  </form>
  <h2>Delete Article</h2>
  <form id="deleteArticleForm" action="/deletearticle" method="POST">
    {{ csrf_field() }}

    <table>
      <tr>
        <td>
           Article ID
        </td>
        <td>
          <input type="number" name="articleID" form="deleteArticleForm">
        </td>
      </tr>
      <tr>
        <td>
          <input type="submit" value="submit">
        </td>
      </tr>
      </table>
  </form>


  <a href="/viewallarticles">View All Articles</a><br/>
  <a href="/viewallpendingarticles">View All Pending Articles</a><br/>
  <a href="/viewallpublishedarticles">View All Published Articles</a><br/>
  <a href="/viewallyourarticles">View All Your Articles</a><br/>

</div>
@endsection
