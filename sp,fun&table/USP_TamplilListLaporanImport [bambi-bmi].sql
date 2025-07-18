USE [bambi-bmi]
GO
/****** Object:  StoredProcedure [dbo].[USP_TamplilListLaporanImport]    Script Date: 05/24/2024 08:10:53 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[USP_TamplilListLaporanImport]
@status VARCHAR(1),
@date_from datetime,
@date_to datetime,
@userid VARCHAR(100)

AS

	IF EXISTS(SELECT [Table_name] FROM tempdb.information_schema.tables WHERE [Table_name] like '#temptess') 
    BEGIN
      DROP TABLE #temptess;
    END;

	CREATE TABLE  #temptess(
		ItemNo INT,
		Tanggal  DATETIME,
		forwaderid VARCHAR(100),
		pc VARCHAR(100),
		importer VARCHAR(100),
		supplierid VARCHAR(100),
		jenisbarang VARCHAR(100),
		userinput VARCHAR(100),
		FlagPosting char(1),
		FlagPrint char(1)

	);
BEGIN

	IF(@status ='Y')
		BEGIN
			INSERT INTO #temptess
			SELECT ItemNo,Tanggal,forwaderid,pc,importer,supplierid,jenisbarang,userinput,FlagPosting,FlagPrint
			FROM  [bambi-bmi].[dbo].forwarder_transactions  WHERE Tanggal BETWEEN @date_from AND  @date_to AND FlagPrint='Y' ORDER BY Tanggal DESC  ;
		END
	  ELSE
		BEGIN
			INSERT INTO #temptess
			SELECT ItemNo,Tanggal,forwaderid,pc,importer,supplierid,jenisbarang,userinput,FlagPosting,FlagPrint
			FROM  [bambi-bmi].[dbo].forwarder_transactions  WHERE Tanggal BETWEEN @date_from AND  @date_to  AND  userinput=@userid AND FlagPrint='Y' ORDER BY Tanggal DESC  ;
	 	END

		SELECT * FROM #temptess
END


GO
EXEC USP_TamplilListLaporanImport  'Y','2025-07-03','2025-07-17', 'wardi'




