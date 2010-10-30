<form action="?action=gravar" method="post">
<input type="hidden" name="id" value="<? echo $user->getId(); ?>" />
<table>
<tr>
<td colspan="3">Criar Usuário</td>
</tr>
<tr>
<td>Nome:</td>
<td width="15"></td>
<td>Login:</td>
</tr>
<tr>
<td><input type="text" name="nome" value="<? echo $user->getNome(); ?>" /></td>
<td></td>
<td><input type="text" name="usuario" value="<? echo $user->getUsuario(); ?>" /></td>
</tr>
<tr height="5">
<td colspan="3"></td>
</tr>
<tr>
<td>Senha:</td>
<td width="15"></td>
<td>Email:</td>
</tr>
<tr>
<td><input type="password" name="senha" value="" /></td>
<td></td>
<td><input type="text" name="email" value="<? echo $user->getEmail(); ?>" /></td>
</tr>
<tr height="5">
<td colspan="3"></td>
</tr>
<tr>
<td colspan="3"><input type="submit" value="Cadastrar" /></td>
</tr>
</table>
</form>
</body>
</html>
