<!-- BEGIN GAMELOG -->
<div class="log">
<p>{GAME}</p>
<table>
<tr>
	<th>Winners</td>
	<th>Losers</td>
</tr>
<tr>
	<td class="winner">{WINNER1}</td>
	<td class="loser">{LOSER1}</td>
</tr>
<!-- BEGIN IMAGES -->
<tr>
	<td colspan="4" ><img src="/images/{IMAGE}" width="285"/></td>
</tr>
<!-- END IMAGES -->
<!-- BEGIN COMMENTS -->
<tr>
	<td colspan="4" class="comment"><b>{NAME}: </b>{COMMENT}</td>
</tr>
<!-- END COMMENTS -->
<tr class="comms">
	<td colspan="4" class="inComment">	
		<form action="comments.php" id="comment_log" method="get">
			<b>Name: </b><br><input type="text" name="name"><br>
			<b>Comment: </b><textarea rows="2" cols="45" name="comment"></textarea><br>
			<input type="hidden" name="gameID" value="{ID}">
			<input type="submit" value="Submit Comment" class="button">
		</form>
	</td>
</tr>
</table>
<form action='upload.php' method='POST' enctype='multipart/form-data' class="comms">
	<p class="img">Add an Image: </p><input type='file' name='myfile'><br>
	<input type="hidden" name="gameID" value="{ID}">
	<input type='submit' value='Upload' class="button">
</form>
<button class="commsbutton">Add Comment or Picture</button><br>
<a href="edit.php?edit={ID}" >Edit</a><br>
</div>
<!-- END GAMELOG -->