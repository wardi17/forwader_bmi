USE [bambi-bmi]
GO
/****** Object:  StoredProcedure [dbo].[USP_CetakPrintForwaderImport]    Script Date: 05/24/2024 08:10:53 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[USP_CetakPrintForwaderImport ]
@ItemNo INT

AS


BEGIN


			--INSERT INTO #temptess
			SELECT ID_document,Tanggal,forwaderid,forwadername,pc,alamat,importer,consignee,
          supplierid,suppliername,coderegion,jenisbarang,hscode,jumlah_volume,pelabuhan_tujuan,eta,no_invoice,shippingline,
          no_bl_awb,container_no,vessel_voyage,userinput,document_files,DOTransacID,DONumber
			FROM  [bambi-bmi].[dbo].forwarder_transactions  WHERE ItemNo=@ItemNo;
	
	 
END


GO
EXEC USP_CetakPrintForwaderImport 2


