USE [bambi-bmi]
GO

/****** Object:  Table [dbo].[supplier]    Script Date: 11/8/2024 8:17:05 AM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[supplier](
	[CustomerID] [char](10) NOT NULL,
	[CustName] [char](50) NOT NULL,
	[CustomerClass] [char](10) NOT NULL,
	[CreditLimit] [float] NULL,
	[LimitTerpakai] [float] NULL,
	[LimitSisa] [float] NULL,
	[umuka] [float] NULL,
	[umukaterpakai] [float] NULL,
	[umukasisa] [float] NULL,
	[CustAddress] [text] NULL,
	[Country] [char](30) NULL,
	[City] [char](50) NULL,
	[coderegion] [char](10) NOT NULL,
	[codesubreg01] [char](10) NOT NULL,
	[codesubreg02] [char](10) NOT NULL,
	[termcode] [char](2) NULL,
	[CustTelpNo] [char](30) NULL,
	[HandPhone] [char](30) NULL,
	[CustFaxNo] [char](30) NULL,
	[CustCoName] [char](30) NULL,
	[CustCoTitle] [varchar](30) NULL,
	[CustEMail] [varchar](40) NULL,
	[CustComment] [text] NULL,
	[CustBillAddress] [text] NULL,
	[CustNPWP] [varchar](20) NULL,
	[COACustomer] [char](15) NULL,
	[CustDelAddress] [text] NULL,
	[Invoice] [float] NULL,
	[Outstanding] [float] NULL,
	[Receipt] [float] NULL,
	[CreditMemo] [float] NULL,
	[TempReceipt] [float] NULL,
	[TempCreditMemo] [float] NULL,
	[DebitNote] [float] NULL,
	[TempDebitNote] [float] NULL,
	[UserId] [char](10) NULL,
	[LastDateAccess] [datetime] NULL,
	[TransNo] [char](15) NULL,
	[salescode] [char](10) NULL,
	[divcode] [char](3) NULL,
	[postcode01] [char](6) NULL,
	[birthplace] [char](20) NULL,
	[birthday] [datetime] NULL,
	[religion] [char](20) NULL,
	[npwpaddress] [text] NULL,
	[kotamadya02] [char](10) NULL,
	[kecamatan02] [char](10) NULL,
	[postcode02] [char](6) NULL,
	[kotamadya03] [char](10) NULL,
	[kecamatan03] [char](10) NULL,
	[postcode03] [char](6) NULL,
	[kotamadya04] [char](10) NULL,
	[kecamatan04] [char](10) NULL,
	[postcode04] [char](6) NULL,
	[cabang] [char](2) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO

ALTER TABLE [dbo].[supplier] ADD  CONSTRAINT [DF_supplier_CreditLimit]  DEFAULT (0) FOR [CreditLimit]
GO

ALTER TABLE [dbo].[supplier] ADD  CONSTRAINT [DF_supplier_LimitTerpakai]  DEFAULT (0) FOR [LimitTerpakai]
GO

ALTER TABLE [dbo].[supplier] ADD  CONSTRAINT [DF_supplier_LimitSisa]  DEFAULT (0) FOR [LimitSisa]
GO

ALTER TABLE [dbo].[supplier] ADD  CONSTRAINT [DF_supplier_umuka]  DEFAULT (0) FOR [umuka]
GO

ALTER TABLE [dbo].[supplier] ADD  CONSTRAINT [DF_supplier_umukaterpakai]  DEFAULT (0) FOR [umukaterpakai]
GO

ALTER TABLE [dbo].[supplier] ADD  CONSTRAINT [DF_supplier_umukasisa]  DEFAULT (0) FOR [umukasisa]
GO

ALTER TABLE [dbo].[supplier] ADD  CONSTRAINT [DF_supplier_Invoice]  DEFAULT (0) FOR [Invoice]
GO

ALTER TABLE [dbo].[supplier] ADD  CONSTRAINT [DF_supplier_Outstanding]  DEFAULT (0) FOR [Outstanding]
GO

ALTER TABLE [dbo].[supplier] ADD  CONSTRAINT [DF_supplier_Receipt]  DEFAULT (0) FOR [Receipt]
GO

ALTER TABLE [dbo].[supplier] ADD  CONSTRAINT [DF_supplier_CreditMemo]  DEFAULT (0) FOR [CreditMemo]
GO

ALTER TABLE [dbo].[supplier] ADD  CONSTRAINT [DF_supplier_TempReceipt]  DEFAULT (0) FOR [TempReceipt]
GO

ALTER TABLE [dbo].[supplier] ADD  CONSTRAINT [DF_supplier_TempCreditMemo]  DEFAULT (0) FOR [TempCreditMemo]
GO

ALTER TABLE [dbo].[supplier] ADD  CONSTRAINT [DF_supplier_DebitNote]  DEFAULT (0) FOR [DebitNote]
GO

ALTER TABLE [dbo].[supplier] ADD  CONSTRAINT [DF_supplier_TempDebitNote]  DEFAULT (0) FOR [TempDebitNote]
GO


