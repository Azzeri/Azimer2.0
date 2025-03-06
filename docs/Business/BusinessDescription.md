### Summary

- **Domain:** Firefighting

### Azimer

1. **Managing Employees in Fire Brigade Units**
    1. **Personal Data:**  
       We need to store employees' personal data, such as first name, last name, and date of birth. Each employee also
       has a position within the unit, and we need to specify which unit the employee belongs to.
    2. **Contact Data:**  
       The system should track employees' contact information, including email and phone number.
    3. **Authentication:**  
       We require authentication mechanisms, such as user registration via a unique link, login, password management,
       and login history.
    4. **Member Role in Unit:**  
       User access within the application should be restricted by predefined roles. These roles determine which
       resources a user can access within their assigned unit.

2. **Managing Units**
    1. **Unit Data:**  
       All fire brigade units should be stored in the system, with fields for their name and address.
    2. **Unit Hierarchy:**  
       The system must support the hierarchy of fire brigade units, allowing us to specify a superior unit. Superior
       units should have access to the subordinate units in their hierarchy.

3. **Managing Equipment**
    1. **Equipment Records:**  
       The system should record all fire brigade equipment, grouped into categories and subcategories. Each subcategory
       has specific properties like identification numbers or dates. Shared properties across items include name,
       manufacturer, and vehicle assignment. Equipment can be grouped into templates, with properties based on
       manufacturer, category, and other necessary specifications. Units should specify which equipment templates they
       create, and templates from other units can be made accessible for inspection and use.
    2. **Equipment Maintenance:**  
       Equipment requires two types of maintenance: periodic and one-time. Maintenance records should include the
       assigned employee, the employee who created the record, and the employee who actually performed the maintenance.
       Each maintenance task should have planned and actual performance dates. For periodic maintenance, once completed,
       the next maintenance should be scheduled according to the specified time interval. One-time maintenance tasks
       should be stored in the history and marked as completed. Employees should be notified about upcoming maintenance
       via email, SMS, or push notifications, as well as through a summary on the main page. Each piece of equipment
       should also be tagged with a QR code that, when scanned, directs users to the item’s detailed page. Equipment
       photos, either for individual items or categories, should also be supported.
    3. **Equipment Usage Logging:**  
       Every equipment usage should be logged in the database, tracking who used the item, when it was used, and for how
       long. Users should also be able to leave a comment regarding the usage.
    4. **Grouping Equipment into Sets:**  
       Equipment items should be able to be grouped into sets for organizational purposes.
    5. **Filling Maintenance:**  
       Some equipment categories are fillable and require periodic filling. The system must track filling activities in
       real-time, including start and end times, the responsible person, and the individual who actually performed the
       filling. The duration of the fill should also be calculated.

4. **Fleet Management**
    1. **Vehicle Data:**  
       Each unit manages a fleet of vehicles. The system should store details of each vehicle, such as plate number,
       name, and make. Additionally, the unit to which each vehicle belongs must be recorded.
