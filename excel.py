import openpyxl
from faker import Faker
import random

fake = Faker()

classes_valides = [4,5,6]
annees_valides = [1]

workbook = openpyxl.Workbook()
sheet = workbook.active

sheet['A1'] = "nomComplet"
sheet['B1'] = "email"
sheet['C1'] = "matricule"
sheet['D1'] = "annee_id"
sheet['E1'] = "classe_id"
sheet['F1'] = "password"

for row in range(2, 12):
    nom_complet = fake.name()
    email = fake.email()
    matricule = fake.unique.random_number(digits=6)
    annee_id = random.choice(annees_valides)
    classe_id = random.choice(classes_valides)
    password = "password"

    sheet[f'A{row}'] = nom_complet
    sheet[f'B{row}'] = email
    sheet[f'C{row}'] = matricule
    sheet[f'D{row}'] = annee_id
    sheet[f'E{row}'] = classe_id
    sheet[f'F{row}'] = password

workbook.save("fakeInscription.xlsx")
