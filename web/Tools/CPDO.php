<?php
class CPDO
{

	protected static $connection = null;
	protected static $requests = array();

	public static function exec($request, $args = array())
	{
		if (!array_key_exists($request,self::$requests))
		{
			if (self::$connection === null) {
				self::$connection = new PDO(DSN_PDO_MYSQL, MYSQL_USER, MYSQL_PASSWORD);
			}

			$t_request = self::$connection->prepare($request);
			self::$requests[$request] = $request;
			$request = $t_request;
		}
		else
		{
			$request = self::$requests[$request];
		}
		
		if (!$request->execute($args)) {
			groaw($request->errorInfo());
		}
		
		$values = $request->fetchAll(PDO::FETCH_CLASS);
		
		return $values;
	}

	public static function execOne($request, $args = array()) {
		$values = self::exec($request, $args);
		
		if (count($values)===1)
		{
			return $values[0];
		}
		
		return $values;
	}
}
?>
