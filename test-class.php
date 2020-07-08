$conn

selectUsers(){
    $query = "testDatabase.dbo.selectUsers";
    $stmt = sqlsrv_prepare($conn, $query, $params);
    if (!sqlsrv_execute($stmt)){
        echo "Error executing SQL Query";
    }
}

selectUserDetails($id){
    $query = "testDatabase.dbo.selectUserDetails ?";
    $params = array(
        array($id, SQLSRV_PARAM_IN)
    );
    $stmt = sqlsrv_prepare($conn, $query, $params);
}