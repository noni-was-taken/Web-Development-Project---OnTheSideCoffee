#include <stdio.h>
#include <stdlib.h>
#define STRING_MAX 50
#define LIST_MAX 10
typedef struct{
	int month;
	int year;
}currentDate;
typedef struct{
	int hireMonth;
	int hireYear;
}hiringDetails;

typedef struct{
	char fName[STRING_MAX];
}empDetails;

typedef struct{
	hiringDetails dateOfHire;
	empDetails employeeInfo;
}employee;

typedef struct{
	employee employeeList[LIST_MAX];
	int count;
}employeeRecords;

employee* getLoyalList(employeeRecords record,int *loyalListCount,currentDate currDate);

void display(empDetails employeeInfo, employee *loyalList,int loyalListCount);
int main(){
	employeeRecords record;
	int employeeCount;
	int loyalListCount=0;
	record.count=0;
	employee *loyalList;
	currentDate date={07,2023};
	
	int i=0;
	printf("Input Number of Employees:" );
    scanf("%d",&employeeCount);
    
    printf("\nInput Details for Employees: \n");
    for(i=0;i<employeeCount;i++){
    	printf("\n\n===Employee %d===\n",i+1);
        printf("Input First Name: ");
    	scanf("%s", &record.employeeList[i].employeeInfo.fName);
        printf("Input Month of Hire: ");
        scanf("%d",&record.employeeList[i].dateOfHire.hireMonth);
    	printf("Input Year of Hire: ");
        scanf("%d",&record.employeeList[i].dateOfHire.hireYear);
    	record.count++;
    
	}
	
	loyalList=getLoyalList(record,&loyalListCount,date);
	
	display(loyalList->employeeInfo,loyalList,loyalListCount);
	
}

employee* getLoyalList(employeeRecords record,int *loyalListCount,currentDate currDate){
    employeeRecords *loyalList = (employeeRecords*) malloc(sizeof(employeeRecords) * record.count);
    

    for(int i=0;i<record.count;i++){
     
            if(record.employeeList[i].dateOfHire.hireYear + 5 <= currDate.year && record.employeeList[i].dateOfHire.hireMonth <= currDate.month){
                loyalList->employeeList[*loyalListCount] = record.employeeList[i]; 
                *loyalListCount += 1;
            }
            else if(record.employeeList[i].dateOfHire.hireYear + 5 < currDate.year ){
                loyalList->employeeList[*loyalListCount] = record.employeeList[i]; 
                *loyalListCount += 1;
            }
	}
	
    loyalList = (employeeRecords*) realloc(loyalList,sizeof(employeeRecords) * record.count);
   
   return (employee*)loyalList->employeeList;
 
}

void display(empDetails employeeInfo, employee*loyalList,int loyalListCount){

    if (loyalListCount == 0){
        printf("There are currently no Employees who are eligible for the reward.");
    }
    else{
    printf("Loyal List: \n\n");
    for(int i=0;i<loyalListCount;i++){
        printf("Name: %s ", loyalList[i].employeeInfo.fName);
        printf("-- Hire Date:%d", loyalList[i].dateOfHire.hireMonth);
        printf("-%d \n", loyalList[i].dateOfHire.hireYear);
    }
    }
}