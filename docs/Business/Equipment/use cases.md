1. Creating/updating a category
    - user must be permitted - application equipment manager
    - name must be unique
    - parent category
        - cannot be itself
        - parent cannot set its child as its parent
2. Deleting a category
    - user must be permitted - application equipment manager
    - there must be no template assigned to this category


3. Creating/updating a manufacturer
    - user must be permitted - application equipment manager
    - name must be unique
4. Deleting a manufacturer
    - user must be permitted - application equipment manager
    - there must be no template assigned to this manufacturer
    -
5. Creating/updating a equipment template
    - user must be permitted - application equipment manager
    - name must be unique
    - must select from the predefined properties
    - at least one property
6. Deleting an equipment template
    - user must be permitted - application equipment manager
    - there must be no equipment assigned to this category

7. Creating/updating an equipment
    - permissions
        - adding to own unit
        - adding to subservient units
        - adding to all units
8. Deleting an equipment
    - permissions
        - deleting from own unit
        - deleting from subservient units
        - deleting from all units
    - only possible if no maintenances were completed/no usages recorded etc.
8. Deactivating an equipment
    - permissions
        - deactivating at own unit
        - deactivating at subservient units
        - deactivating at all units

